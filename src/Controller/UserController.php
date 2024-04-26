<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Symfony\Bundle\SecurityBundle\SecurityBundle;

use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/user')]
class UserController extends AbstractController
{
   // private $userAuthenticator;

   // public function __construct(AppAuthenticator $userAuthenticator)
    //{
      //  $this->userAuthenticator = $userAuthenticator;
    //}
    #[Route('/f', name: 'app_user', methods: ['GET'])]
    public function indexFRONT(UserRepository $userRepository): Response
    {
        return $this->render('user/indexFRONT.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function indexBACK(UserRepository $userRepository): Response
    {
        return $this->render('user/indexBACK.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/signup', name: 'app_user_signup', methods: ['GET', 'POST'])]
    public function signup(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
    
            // Check the user's role and redirect accordingly
            if ($user->getRoleUser() === 'ADMIN') {
                return $this->redirectToRoute('app_testback');
            } elseif ($user->getRoleUser() === 'CLIENT') {
                // Render the profile.html.twig template with the additional navigation item
                return $this->render('user/profile/profile.html.twig', [
                    'user' => $user,
                    'navItems' => [
                        'nav-item' => '<li class="nav-item"><a class="nav-link page-scroll" href="#accounts">PROFILE</a></li>',
                    ],
                ]);
            }
    
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('user/signup/signup.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
 

    #[Route('/{id_user}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id_user}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id_user}', name: 'app_user_delete')]
    public function delete($id_user, ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(User::class);
        $em = $doctrine->getManager();
        $User = $repo->find($id_user);
        $em->remove($User);
        $em->flush();
        return $this->redirectToRoute('app_user_index');
    }
//
  
#[Route("/search", name:"app_user_search",methods: ['GET'])]
public function search(Request $request, UserRepository $userRepository): Response
{
    $search = $request->query->get('search');
    $users = $userRepository->findByPartialNameOrCin($search); // Implement this method in your UserRepository

    return $this->render('user/search_results.html.twig', [
        'users' => $users,
    ]);
}



  

/*#[Route('/profile', name: 'app_profile', methods: ['GET', 'POST'])]
public function profile(Request $request, AuthenticationUtils $auth): Response
{
    $user = $auth->getLastUsername();

    if (!$user) {
        throw $this->createNotFoundException('User not found.');
    }

    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // Redirect or display a success message
        return $this->redirectToRoute('app_profile');
    }

    return $this->render('user/profile/profile.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
}
*/
/**
 * @Route("/stats/users", name="stats_users")
 */
public function userStatistics(UserRepository $userRepo)
{
    // Get all users
    $users = $userRepo->findAll();

    $roles = [];
    $roleCount = [];

    // Separate users based on their roles
    foreach ($users as $user) {
        $role = $user->getRoleUser();
        if (!in_array($role, $roles)) {
            $roles[] = $role;
            $roleCount[$role] = 1;
        } else {
            $roleCount[$role]++;
        }
    }

    // Encode the data for ChartJS
    $roleLabels = json_encode(array_keys($roleCount));
    $roleCounts = json_encode(array_values($roleCount));

    return $this->render('user/user_stats.html.twig', [
        'roleLabels' => $roleLabels,
        'roleCounts' => $roleCounts,
    ]);
}

}  

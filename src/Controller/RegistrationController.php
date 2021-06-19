<?php
namespace App\Controller;

use App\Form\ProfileUserType;
use App\Entity\User;
use App\Mail\NotificationMailManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @var NotificationMailManager
     */
    private NotificationMailManager $mailManager;

    /**
     * @param NotificationMailManager $mailManager
     */
    public function __construct(NotificationMailManager $mailManager)
    {
        $this->mailManager = $mailManager;
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(ProfileUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $context = [
                'url' => $request->getSchemeAndHttpHost() . $this->generateUrl('login'),
            ];

            $this->mailManager->sendRegistrationNotification($user, $context);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
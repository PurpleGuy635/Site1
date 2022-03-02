<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Form\AvisType;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Contact;
use App\Entity\Avis;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
          
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){   
                $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('admin@purpleguy.ovh')
                ->subject($contact->getSujet())
                ->htmlTemplate('emails/emailcontact.html.twig')
                ->context([
                    'nom'=> $contact->getNom(),
                    'sujet'=> $contact->getSujet(),
                    'message'=> $contact->getMessage()
                ]);

                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
              
                $mailer->send($email);
                $this->addFlash('notice','Message envoyé');
                return $this->redirectToRoute('contact');
            }
        }

        return $this->render('base/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/connexion', name: 'connexion')] 
    public function connexion(): Response 
    {
        return $this->render('base/connexion.html.twig', [ 
            
        ]);
    }

    #[Route('/inscription', name: 'inscription')] 
    public function inscription(): Response 
    {

        $form = $this->createForm(InscriptionType::class);

        return $this->render('base/inscription.html.twig', [
            'form' => $form->createView()

        ]);
    }

    #[Route('/avis', name: 'avis')] 
    public function avis(Request $request, MailerInterface $mailer): Response 
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){   
                $email = (new TemplatedEmail())
                ->from($avis->getEmail())
                ->to('admin@purpleguy.ovh')
                ->htmlTemplate('emails/emailavis.html.twig')
                ->context([
                    'nom'=> $avis ->getNom(),
                    'message'=> $avis ->getMessage(),
                    'note'=> $avis ->getNote()
                ]);

                $em = $this->getDoctrine()->getManager();
                $em->persist($avis);
                $em->flush();
              
                $mailer->send($email);
                $this->addFlash('notice','Avis déposé');
                return $this->redirectToRoute('avis');
            }
        }


        return $this->render('base/avis.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/demandecarte', name: 'demandecarte')] 
    public function demandecarte(): Response 
    {
        return $this->render('base/demandecarte.html.twig', [ 
            
        ]);
    }

    #[Route('/demanderepas', name: 'demanderepas')] 
    public function demanderepas(): Response 
    {
        return $this->render('base/demanderepas.html.twig', [ 
            
        ]);
    }
} 

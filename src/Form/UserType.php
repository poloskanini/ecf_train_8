<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'label' => 'Type de client',
                'required' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-select',
                    'placeholder' => 'Type de client'
                ],
                'choices'  => [
                        'Partenaire' => 'ROLE_PARTNER',
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du partenaire',
                'required' => true,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du partenaire',
                'required' => true,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 60
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir une adresse email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent ??tre identiques',
                'label' => false,
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir un mot de passe'
                    ]
                ],
            ])
            ->add('partnerName', TextType::class, [
                'mapped' => false,                  // Avec 'mapped' => false, je peux ajouter un champ qui n'est reli?? ?? aucune entit??,
                                                    // et g??rer ensuite, au sein du controlleur, ?? quelle variable je les affecte via les m??thodes de mes entit??s
                'label' => 'Nom de l\'??tablissement Partenaire',
                'required' => true,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir le nom du Partenaire',
                    'mapped' => false
                ]
            ])

            ->add('isPlanning', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label' => 'Planning',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('isNewsletter', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label' => 'Newsletter',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('isBoissons', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label' => 'Boissons',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('isSms', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label' => 'Sms',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('isConcours', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label' => 'Concours',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            // ->add('submit', SubmitType::class)
            


            // A ins??rer dans le StructureType, qui sera reli?? au StructureController
            
            // $builder->add('postalAdress', EntityType::class, [
            //     'class' => Partner::class,
            //     'query_builder' => function (PartnerRepository $pr) {
            //         return $pr->createQueryBuilder('u')
            //             ->orderBy('u.name', 'ASC');
            //     },
            //     'label' => 'Nom du partenaire rattach?? ?? la structure :',
            //     'mapped' => false
            // ])
      
            ->add('submit', SubmitType::class)
        ;

            // $builder->get('postalAdress')->addEventListener(
            //     FormEvents::POST_SUBMIT,
            //     function (FormEvent $event) {
            //         $form = $event->getForm();
            //         $form->getParent()->add('isPlanning', EntityType::class, [
            //             'class' => 'App\Entity\Partner',
            //             'placeholder' => 'S??lectionnez votre partenaire',
            //             'mapped' => false,
            //             'required' => false,
            //             'choices' => $form->getData()->getPermissions()
            //         ]);
            //     }
            // );

        // Data transformer for Roles array
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     return [$rolesString];
                }
        ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

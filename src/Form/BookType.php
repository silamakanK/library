<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Genre;
use App\Enum\GenreStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('publish_date', null, [
                'widget' => 'single_text',
            ])
            ->add('number_of_copy')
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'id',
            ])
            ->add('genre', EnumType::class, [
                'class' => GenreStatus::class,
                'required' => true,
                'label' => 'Genre',
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}

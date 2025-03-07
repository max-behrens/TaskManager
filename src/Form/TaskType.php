<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'border p-2 flex-grow rounded-l', 'placeholder' => 'New task...']
            ])
            ->add('is_done', CheckboxType::class, [
                'required' => false,
                'label' => 'Done',
                'data' => false,
            ]);

        // Add 'save' button only if 'show_save_button' is true.
        if ($options['show_save_button']) {
            $builder->add('save', SubmitType::class, [
                'label' => 'Add Task',
                'attr' => ['class' => 'bg-blue-500 text-white px-4 py-2 rounded-r']
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'show_save_button' => true,
        ]);
    }
}

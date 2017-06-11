<?php

namespace AndreySerdjuk\SymfonyFormViewNormalizer;

use Symfony\Component\Form\FormView;

/**
 * Describes interface for all Symfony FormViewNormalizers.
 */
interface FormViewNormalizerInterface
{
    /**
     * @param FormView $formView
     * @return array
     */
    public function normalize(FormView $formView);

    /**
     * @param FormView $formView
     * @return bool
     */
    public function supports(FormView $formView);
}

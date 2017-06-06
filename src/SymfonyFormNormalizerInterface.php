<?php

namespace AndreySerdjuk\SymfonyFormNormalizer;

use Symfony\Component\Form\FormView;

interface SymfonyFormNormalizerInterface
{
    /**
     * @param FormView $formView
     * @return array
     */
    public function normalize(FormView $formView);
}

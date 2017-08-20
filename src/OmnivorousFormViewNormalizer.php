<?php

namespace AndreySerdjuk\SymfonyFormViewNormalizer;

use Symfony\Component\Form\FormView;

/**
 * As every form view has common structure it can be normalized in common way.
 * This normalizer allows you not worry about normalizing extraordinary form views.
 * But in case form view needs special normalization - use separate normalizer instead / in addition.
 */
class OmnivorousFormViewNormalizer implements FormViewNormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize(FormView $formView)
    {
        $output['widget_attributes'] = $this->extractAttrs($formView);

        if (isset($formView->children) && $formView->children) {
            $output['children'] = [];
            foreach ($formView->children as $name => $child) {
                $output['children'][$name] = $this->normalize($child);
            }
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(FormView $formView)
    {
        return true;
    }

    /**
     * @param FormView $formView
     * @return array
     */
    protected function extractAttrs(FormView $formView)
    {
        $normalizedView = [];

        foreach ($formView->vars as $key => $val) {
            if (in_array($key, ['placeholder', 'title'])) {
                // todo escape and translate, @see vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/widget_container_attributes.html.php
                if (false !== $formView->vars['translation_domain']) {
                    // todo translate val below
                }
                $normalizedView[$key] = $val;
            } elseif (is_bool($val)) {
                // todo escape key
                $normalizedView[$key] = $val;
            } elseif (in_array(gettype($val), ['string', 'integer', 'float'])) {
                // todo or if it's object with __toString()
                // todo escape key and val
                $normalizedView[$key] = $val;
            }
        }

        if (isset($formView->vars['choices'])) {
            foreach ($formView->vars['choices'] as $choice) {
                $normalizedView['choices'][] = (array) $choice;
            }
        }

        if (isset($formView->vars['block_prefixes'])) {
            $normalizedView['block_prefixes'] = $formView->vars['block_prefixes'];
        }

        return $normalizedView;
    }
}

<?php

namespace AndreySerdjuk\SymfonyFormViewNormalizer;

use Symfony\Component\Form\FormView;

class DelegatingFormViewNormalizer implements FormViewNormalizerInterface
{
    const INPUT_TYPE = 'input_type';

    /**
     * @var FormViewNormalizerInterface[]
     */
    protected $normalizers = [];

    /**
     * @param FormView $formView
     * @return array
     */
    public function normalize(FormView $formView)
    {
        $normalizedView = [];

        $normalizedView['name'] = $formView->vars['name'];
        $normalizedView['method'] = strtolower($formView->vars['method']);

        if (isset($formView->vars['action']) && $formView->vars['action']) {
            $normalizedView['action'] = $formView->vars['action'];
        }

        $normalizedView['widget_container_attributes'] = $this->extractAttrs($formView);

        $normalizedView += $formView->vars['attr'];

        foreach ($formView->children as $name => $child) {
            $normalizedView['children'][$name] = $this->normalizeChild($child);
        }

        return $normalizedView;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(FormView $formView)
    {
        return (bool) $this->findNormalizer($formView);
    }

    public function addNormalizer(FormViewNormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    protected function normalizeChild(FormView $formView)
    {
        $output = [];

        if ($normalizer = $this->findNormalizer($formView)) {
            $output = $normalizer->normalize($formView);
        } else {
            $output['widget_attributes'] = $this->extractAttrs($formView);

            if (true === $formView->vars['compound']) {
                foreach ($formView->children as $name => $child) {
                    $output['children'][$name] = $this->normalizeChild($child);
                }
            }
        }

        return $output;
    }

    protected function findNormalizer(FormView $formView)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($formView)) {
                return $normalizer;
            }
        }
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

        $normalizedView['block_prefixes'] = $formView->vars['block_prefixes'];
//        if (!isset($normalizedView['type']) && !$formView->vars['compound']) {
//            $normalizedView['type'] = 'text';
//        }
//
//        $typeKey = count($formView->vars['block_prefixes']) - 1;
//        $output[self::INPUT_TYPE] = $formView->vars['block_prefixes'][$typeKey];

        return $normalizedView;
    }
}

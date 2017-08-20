<?php

namespace AndreySerdjuk\SymfonyFormViewNormalizer;

use Symfony\Component\Form\FormView;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * As every form view has common structure it can be normalized in common way.
 * This normalizer allows you not worry about normalizing extraordinary form views.
 * But in case form view needs special normalization - use separate normalizer instead / in addition.
 */
class OmnivorousFormViewNormalizer implements FormViewNormalizerInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
            if (in_array($key, ['placeholder', 'title', 'label'])) {
                if (false !== $formView->vars['translation_domain']) {
                    $val = $this->translator->trans($val, [], $formView->vars['translation_domain']);
                }
                $normalizedView[$key] = $val;
            } elseif (is_bool($val)) {
                $normalizedView[$key] = $val;
            } elseif (in_array(gettype($val), ['string', 'integer', 'float'])) {
                $normalizedView[$key] = $val;
            } elseif (method_exists($val, '__toString')) {
                $normalizedView[$key] = (string) $val;
            }
        }

        if (isset($formView->vars['choices'])) {
            foreach ($formView->vars['choices'] as $choice) {
                $choiceArr = (array) $choice;
                $choiceArr['label'] = $this->translator->trans($choiceArr['label']);
                $normalizedView['choices'][] = $choiceArr;
            }
        }

        if (isset($formView->vars['block_prefixes'])) {
            $normalizedView['block_prefixes'] = $formView->vars['block_prefixes'];
        }

        return $normalizedView;
    }
}

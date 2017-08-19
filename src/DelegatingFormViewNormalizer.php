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

        $normalizedView['id'] = $formView->vars['id'];
        $normalizedView['name'] = $formView->vars['name'];
        $normalizedView['label'] = $formView->vars['label'];
        $normalizedView['label_format'] = $formView->vars['label_format'];
        $normalizedView['read_only'] = $formView->vars['read_only'];
        $normalizedView['multipart'] = $formView->vars['multipart'];
        $normalizedView['valid'] = $formView->vars['valid'];
        $normalizedView['method'] = strtolower($formView->vars['method']);
        $normalizedView['action'] = $formView->vars['action'];
        $normalizedView['attr'] = $formView->vars['attr'];

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
        } elseif (isset($formView->vars['compound']) && true === $formView->vars['compound']) {
            foreach ($formView->children as $name => $child) {
                $output['children'][$name] = $this->normalizeChild($child);
            }
        } else {
            throw new \RuntimeException(sprintf(
                'Cannot normalize form type for "%s" field.',
                $formView->vars['full_name']
            ));
        }

        return $output;
    }

    protected function findNormalizer(FormView $formView)
    {
        $normalizer = null;

        foreach ($this->normalizers as $n) {
            if ($n->supports($formView)) {
                $normalizer = $n;
            }
        }

        return $normalizer;
    }
}

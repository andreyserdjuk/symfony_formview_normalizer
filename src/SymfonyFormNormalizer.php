<?php

namespace AndreySerdjuk\SymfonyFormNormalizer;

use Symfony\Component\Form\FormView;

class SymfonyFormNormalizer
{
    public function normalize(FormView $formView)
    {
        $normalizedView = ['children' => []];

        if (true === $formView->vars['compound']) {
            foreach ($formView->children as $childName => $child) {
                $normalizedView['children'][$childName] = $this->normalize($child);
            }
        }

        $normalizedView['vars'] = $this->extractVars($formView);

        return $normalizedView;
    }

    protected function extractVars(FormView $formView)
    {
        $vars = [];

        foreach ($formView->vars as $varName => $var) {
            if (!is_object($var)) {
                $vars[$varName] = $var;
            }
        }

        return $vars;
    }
}

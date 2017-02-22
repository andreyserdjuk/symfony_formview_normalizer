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

        $normalizedView['vars'] = $this->filterVars($formView->vars);

        return $normalizedView;
    }

    /**
     * Remove huge extra vars like choices for date, time etc.
     *
     * @param array $vars
     * @return array
     */
    protected function filterVars(array $vars)
    {
//        $blockPrefixes = isset($formView->vars['block_prefixes'])?:[];

//        if (isset($blockPrefixes[1]['choice'])) {
//        }
        $output = [];

        foreach ($vars as $varName => $var) {
            if (is_array($var)) {
                $vars[$varName] = $this->filterVars($var);
            }

            if (!is_object($var)) {
                $output[$varName] = $var;
            }
        }

        return $output;
    }
}

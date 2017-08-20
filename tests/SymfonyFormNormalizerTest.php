<?php

namespace Tests;

use AndreySerdjuk\SymfonyFormViewNormalizer\DelegatingFormViewNormalizer;
use AndreySerdjuk\SymfonyFormViewNormalizer\OmnivorousFormViewNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Forms;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;
use Tests\Form\TestFormType;

/**
 * Class SymfonyFormNormalizerTest
 * @package AndreySerdjuk\SymfonyFormNormalizer\Tests
 */
class SymfonyFormNormalizerTest extends TestCase
{
    public function testNormilize()
    {
        $formView = Forms::createFormFactory()->create(TestFormType::class)->createView();
        $normalizer = new DelegatingFormViewNormalizer();

        $translator = new Translator('fr_FR');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [
            'Symfony is great!' => 'J\'aime Symfony!',
            'test_label_1' => 'Étiquette de test',
        ], 'fr_FR');

        $normalizer->addNormalizer(new OmnivorousFormViewNormalizer($translator));
        $data = $normalizer->normalize($formView);

        $this->assertTrue(is_array($data));
        $this->assertArrayHasKey('children', $data);
        $this->assertCount(33, $data['children']);

        foreach ($data['children'] as $childData) {
            $this->assertChildren($childData);
        }

        $this->assertEquals(
            'J\'aime Symfony!',
            $data['children']['checkbox']['widget_attributes']['label'],
            'Translation of checkbox failed.'
        );

        $this->assertEquals(
            'J\'aime Symfony!',
            $data['children']['choice_multiple_expanded']['widget_attributes']['label'],
            'Translation of choice_multiple_expanded label failed.'
        );

        $this->assertEquals(
            'Étiquette de test',
            $data['children']['choice_multiple_expanded']['widget_attributes']['choices'][0]['label'],
            'Translation of choice_multiple_expanded first choice label failed.'
        );

        $this->assertEquals(
            'Étiquette de test',
            $data['children']['choice_multiple_expanded']['children'][0]['widget_attributes']['label'],
            'Translation of choice_multiple_expanded first children (choice) label failed.'
        );
    }

    protected function assertChildren($childData)
    {
        $this->assertArrayHasKey('widget_attributes', $childData);
        $this->assertArrayHasKey('name', $childData['widget_attributes']);
        $this->assertArrayHasKey('id', $childData['widget_attributes']);

        if (isset($childData['children'])) {
            foreach ($childData['children'] as $child) {
                $this->assertChildren($child);
            }
        }
    }
}

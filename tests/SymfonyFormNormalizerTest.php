<?php

namespace Tests;

use AndreySerdjuk\SymfonyFormViewNormalizer\DelegatingFormViewNormalizer;
use AndreySerdjuk\SymfonyFormViewNormalizer\OmnivorousFormViewNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Forms;
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
        $normalizer->addNormalizer(new OmnivorousFormViewNormalizer());
        $data = $normalizer->normalize($formView);

        $this->assertTrue(is_array($data));
        $this->assertArrayHasKey('children', $data);
        $this->assertCount(33, $data['children']);

        foreach ($data['children'] as $childData) {
            $this->assertArrayHasKey('widget_attributes', $childData);
            $this->assertArrayHasKey('name', $childData['widget_attributes']);
            $this->assertArrayHasKey('id', $childData['widget_attributes']);
        }
    }
}

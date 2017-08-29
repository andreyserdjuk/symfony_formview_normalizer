<?php

namespace Tests\AndreySerdjuk\SymfonyFormViewNormalizer;

use AndreySerdjuk\SymfonyFormViewNormalizer\DelegatingFormViewNormalizer;
use AndreySerdjuk\SymfonyFormViewNormalizer\OmnivorousFormViewNormalizer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;
use Tests\AndreySerdjuk\SymfonyFormViewNormalizer\src\TestBundle\Form\PostType;
use Tests\AndreySerdjuk\SymfonyFormViewNormalizer\src\TestBundle\Form\TestFormType;

/**
 * Class SymfonyFormNormalizerTest
 */
class SymfonyFormNormalizerTest extends WebTestCase
{
    /** @var  Client */
    protected $client;

    protected static function getKernelClass()
    {
        require_once __DIR__.'/app/AppKernel.php';

        return '\Tests\AndreySerdjuk\SymfonyFormViewNormalizer\app\AppKernel';
    }

    protected static function createKernel(array $options = array())
    {
        $class = self::getKernelClass();

        if (!isset($options['test_case'])) {
            throw new \InvalidArgumentException('The option "test_case" must be set.');
        }

        return new $class(
            $options['test_case'],
            isset($options['root_config']) ? $options['root_config'] : 'config.yml',
            isset($options['environment']) ? $options['environment'] : 'frameworkbundletest'.strtolower($options['test_case']),
            isset($options['debug']) ? $options['debug'] : true
        );
    }

    public function testNormalizeDoctrineType()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->client->getContainer()->get('default_entity_manager');
        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $tool = new SchemaTool($em);
        $tool->createSchema($metadatas);

        $formView = $this->client->getContainer()
            ->get('form.factory')
            ->create(PostType::class)
            ->createView();

        $normalizer = new DelegatingFormViewNormalizer();
        $translator = new Translator('fr_FR');
        $normalizer->addNormalizer(new OmnivorousFormViewNormalizer($translator));
        $data = $normalizer->normalize($formView);

        $this->assertTrue(is_array($data));
        $this->assertArrayHasKey('children', $data);

        foreach ($data['children'] as $childData) {
            $this->assertChildren($childData);
        }

        $this->assertCount(3, $data['children']);
    }

    public function testNormilizeAllCoreExtensionTypes()
    {
        $client = static::createClient([
            'test_case' => 'DoctrineInit',
            'root_config' => 'config.yml',
        ]);

        $formView = $client->getContainer()
            ->get('form.factory')
            ->create(TestFormType::class)
            ->createView();

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
        $this->assertCount(34, $data['children']);

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

    protected function setUp()
    {
        $this->client = static::createClient([
            'test_case' => 'DoctrineInit',
            'root_config' => 'config.yml',
        ]);
    }

    protected function tearDown()
    {
        (new Filesystem())->remove(static::$kernel->getCacheDir());
        parent::tearDown();
    }
}

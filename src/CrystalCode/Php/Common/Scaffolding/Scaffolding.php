<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\Templates\DefaultTemplateRenderer;
use CrystalCode\Php\Common\Templates\TemplateBase;
use CrystalCode\Php\Common\Templates\TemplateContextInterface;
use CrystalCode\Php\Common\Templates\TemplateInterface;

require_once sprintf('%s/../../../../../vendor/autoload.php', __DIR__);

/**
 * 
 * @param string $string
 * @param mixed $values
 * @return string
 */
function interpolate($string, $values)
{
    $values = Collection::create($values)->toArray();
    return preg_replace_callback('({(?<name>\w+)})i', function (array $match) use ($values) {
        if (isset($values[$match['name']])) {
            return (string) $values[$match['name']];
        }
        return (string) null;
    }, $string);
}

/**
 * 
 * @return ItemInterface
 */
function get_item()
{
    return new DirectoryItem('Templates', function () {
        yield new DirectoryItem('Public', function () {
            yield new DefaultFileItem('PublicStateCtrlTemplate.php');
            yield new DefaultFileItem('PublicStateHtmlTemplate.php');
            yield new DefaultFileItem('PublicStateScssTemplate.php');
            yield new DirectoryItem('About', function () {
                yield new DefaultFileItem('AboutStateCtrlTemplate.php');
                yield new DefaultFileItem('AboutStateHtmlTemplate.php');
                yield new DefaultFileItem('AboutStateScssTemplate.php');
            });
            yield new DirectoryItem('Login', function () {
                yield new DefaultFileItem('LoginStateCtrlTemplate.php');
                yield new DefaultFileItem('LoginStateHtmlTemplate.php');
                yield new DefaultFileItem('LoginStateScssTemplate.php');
            });
        });
        yield new DirectoryItem('Private', function () {
            yield new DefaultFileItem('PrivateStateCtrlTemplate.php');
            yield new DefaultFileItem('PrivateStateHtmlTemplate.php');
            yield new DefaultFileItem('PrivateStateScssTemplate.php');
            yield new DirectoryItem('Management', function () {
                yield new DefaultFileItem('ManagementStateCtrlTemplate.php');
                yield new DefaultFileItem('ManagementStateHtmlTemplate.php');
                yield new DefaultFileItem('ManagementStateScssTemplate.php');
                yield new DirectoryItem('Dashboard', function () {
                    yield new DefaultFileItem('DashboardStateCtrlTemplate.php');
                    yield new DefaultFileItem('DashboardStateHtmlTemplate.php');
                    yield new DefaultFileItem('DashboardStateScssTemplate.php');
                });
                yield new DirectoryItem('Entity', function () {
                    yield new DefaultFileItem('EntityStateCtrlTemplate.php');
                    yield new DefaultFileItem('EntityStateHtmlTemplate.php');
                    yield new DefaultFileItem('EntityStateScssTemplate.php');
                    yield new DirectoryItem('Select', function () {
                        yield new DefaultFileItem('SelectStateCtrlTemplate.php');
                        yield new DefaultFileItem('SelectStateHtmlTemplate.php');
                        yield new DefaultFileItem('SelectStateScssTemplate.php');
                    });
                    yield new DirectoryItem('Create', function () {
                        yield new DefaultFileItem('CreateStateCtrlTemplate.php');
                        yield new DefaultFileItem('CreateStateHtmlTemplate.php');
                        yield new DefaultFileItem('CreateStateScssTemplate.php');
                    });
                    yield new DirectoryItem('Detail', function () {
                        yield new DefaultFileItem('DetailStateCtrlTemplate.php');
                        yield new DefaultFileItem('DetailStateHtmlTemplate.php');
                        yield new DefaultFileItem('DetailStateScssTemplate.php');
                        yield new DirectoryItem('View', function () {
                            yield new DefaultFileItem('ViewStateCtrlTemplate.php');
                            yield new DefaultFileItem('ViewStateHtmlTemplate.php');
                            yield new DefaultFileItem('ViewStateScssTemplate.php');
                        });
                        yield new DirectoryItem('Edit', function () {
                            yield new DefaultFileItem('EditStateCtrlTemplate.php');
                            yield new DefaultFileItem('EditStateHtmlTemplate.php');
                            yield new DefaultFileItem('EditStateScssTemplate.php');
                        });
                    });
                });
                yield new DirectoryItem('Account', function () {
                    yield new DefaultFileItem('AccountStateCtrlTemplate.php');
                    yield new DefaultFileItem('AccountStateHtmlTemplate.php');
                    yield new DefaultFileItem('AccountStateScssTemplate.php');
                    yield new DirectoryItem('Profile', function () {
                        yield new DefaultFileItem('ProfileStateCtrlTemplate.php');
                        yield new DefaultFileItem('ProfileStateHtmlTemplate.php');
                        yield new DefaultFileItem('ProfileStateScssTemplate.php');
                    });
                    yield new DirectoryItem('Settings', function () {
                        yield new DefaultFileItem('SettingsStateCtrlTemplate.php');
                        yield new DefaultFileItem('SettingsStateHtmlTemplate.php');
                        yield new DefaultFileItem('SettingsStateScssTemplate.php');
                    });
                });
            });
        });
    });
}

function main()
{
    $item = get_item();
    $templateRenderer = new DefaultTemplateRenderer();
    $itemProcessor = new DefaultItemProcessor($templateRenderer);
    $instructions = $itemProcessor->processItem($item);
    foreach (Collection::create($instructions) as $instruction) {
        echo $instruction->toString() . PHP_EOL;
    }
}

main();

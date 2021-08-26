<?php

namespace Gebruederheitz\Wordpress;

class GoogleTagManager {

    private const TEMPLATE_PATH = __DIR__ . '/../templates/snippet.php';
    private const OVERRIDE_PATH = 'template-parts/blocks/gtm.php';

    private $containerId;
    private $overridePath = self::OVERRIDE_PATH;

    /**
     * @param string|null $containerId A custom GTM container ID to override the
     *                                 environment setting.
     * @param string|null $overridePath A custom path to a custom template
     *                                  replacing the default 'template-parts/blocks/gtm.php'.
     */
    public function __construct(
        ?string $containerId = null,
        ?string $overridePath = null
    ) {
        if (!empty($containerId)) {
            $this->containerId = $containerId;
        } else if (defined('GTM_CONTAINER_ID') && !empty(GTM_CONTAINER_ID)) {
            $this->containerId = GTM_CONTAINER_ID;
        }

        if (!empty($overridePath)) {
            $this->overridePath = $overridePath;
        }

        if (!empty($this->containerId)) {
            add_action('wp_head', [$this, 'renderScriptSnippet']);
        }
    }

    public function renderScriptSnippet()
    {
        $templatePathUsed = self::TEMPLATE_PATH;

        if ($overriddenTemplate = locate_template($this->overridePath)) {
            $templatePathUsed = $overriddenTemplate;
        }

        // ob_start();
        load_template($templatePathUsed, false, [$this->containerId]);
        // $content = ob_get_contents();
        // ob_end_clean();
    }
}


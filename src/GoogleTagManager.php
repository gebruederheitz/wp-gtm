<?php

namespace Gebruederheitz\Wordpress;

class GoogleTagManager
{
    private const TEMPLATE_PATH = __DIR__ . '/../templates/snippet.php';
    private const OVERRIDE_PATH = 'template-parts/blocks/gtm.php';
    private const DEFAULT_GTM_SCRIPT_URL = 'https://www.googletagmanager.com/gtm.js';

    private $containerId;
    private $overridePath = self::OVERRIDE_PATH;
    private $gtmScriptUrl = self::DEFAULT_GTM_SCRIPT_URL;

    /**
     * @param string|null $containerId A custom GTM container ID to override the
     *                                 environment setting.
     * @param string|null $overridePath A custom path to a custom template
     *                                  replacing the default 'template-parts/blocks/gtm.php'.
     * @param string|null $overrideGtmScriptUrl A custom url to load the GTM container from. Can be used
     *                                  for server side tagging.
     */
    public function __construct(
        ?string $containerId = null,
        ?string $overridePath = null,
        ?string $overrideGtmScriptUrl = null
    ) {
        if (!empty($containerId)) {
            $this->containerId = $containerId;
        } elseif (defined('GTM_CONTAINER_ID') && !empty(GTM_CONTAINER_ID)) {
            $this->containerId = GTM_CONTAINER_ID;
        }

        if (!empty($overridePath)) {
            $this->overridePath = $overridePath;
        }

        if (!empty($overrideGtmScriptUrl)) {
            $this->gtmScriptUrl = $overrideGtmScriptUrl;
        } elseif (defined('GTM_SCRIPT_URL') && !empty(GTM_SCRIPT_URL)) {
            $this->gtmScriptUrl = GTM_SCRIPT_URL;
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
        load_template($templatePathUsed, false, [
            $this->containerId,
            $this->gtmScriptUrl,
        ]);
        // $content = ob_get_contents();
        // ob_end_clean();
    }
}

{**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 *}

<div class="elementor-subscribe-wrapper elementor-widget-button">
  <form id="emailsubscription" action="#emailsubscription" method="post">
    <input class="elementor-input"
      name="email"
      type="email"
      value="{$value}"
      placeholder="{if empty($settings.placeholder)}{l s='Your email address' d='Shop.Forms.Labels'}{else}{$settings.placeholder}{/if}"
      required
    ><button class="elementor-button elementor-animation-{$settings.hover_animation}" name="submitNewsletter" value="1">
      <span class="elementor-button-content-wrapper">
        {if $settings.icon}
          <span class="elementor-button-icon elementor-align-icon-{$settings.icon_align}">
            <i class="{$settings.icon}"></i>
          </span>
        {/if}
        <span class="elementor-button-text">{if empty($settings.button)}{l s='Subscribe' d='Shop.Theme.Actions'}{else}{$settings.button}{/if}</span>
      </span>
    </button>
    <input type="hidden" name="action" value="0">
  </form>
  {if $msg}
    <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
      {$msg}
    </p>
  {/if}
</div>

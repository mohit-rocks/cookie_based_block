<?php

namespace Drupal\cookie_based_block\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;

/**
* Provides a 'Validate cookie' condition to enable a condition based in module selected status.
*
* @Condition(
*   id = "validate_cookie",
*   label = @Translation("Validate cookie"),
* )
*
*/
class ValidateCookie extends ConditionPluginBase {

/**
* {@inheritdoc}
*/
public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
{
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition
    );
}

/**
 * Creates a new ValidateCookie object.
 *
 * @param array $configuration
 *   The plugin configuration, i.e. an array with configuration values keyed
 *   by configuration option name. The special key 'context' may be used to
 *   initialize the defined contexts by setting it to an array of context
 *   values keyed by context names.
 * @param string $plugin_id
 *   The plugin_id for the plugin instance.
 * @param mixed $plugin_definition
 *   The plugin implementation definition.
 */
 public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
 }

 /**
   * {@inheritdoc}
   */
 public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
   $form['cookie_name'] = [
     '#type' => 'textfield',
     '#title' => $this->t('Cookie Name'),
     '#maxlength' => 255,
     '#size' => 64,
     '#required' => FALSE,
     '#default_value' => $this->configuration['cookie_name'],
   ];

   $form['cookie_value'] = [
     '#type' => 'textfield',
     '#title' => $this->t('Cookie Value'),
     '#maxlength' => 255,
     '#size' => 64,
     '#required' => FALSE,
     '#default_value' => $this->configuration['cookie_value'],
   ];

   return parent::buildConfigurationForm($form, $form_state);
 }

/**
 * {@inheritdoc}
 */
 public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
     $this->configuration['cookie_name'] = $form_state->getValue('cookie_name');
     $this->configuration['cookie_value'] = $form_state->getValue('cookie_value');
     parent::submitConfigurationForm($form, $form_state);
 }

/**
 * {@inheritdoc}
 */
 public function defaultConfiguration() {
    return [
      'cookie_name' => '',
      'cookie_value' => '',
      ] + parent::defaultConfiguration();
 }

/**
  * Evaluates the condition and returns TRUE or FALSE accordingly.
  *
  * @return bool
  *   TRUE if the condition has been met, FALSE otherwise.
  */
  public function evaluate() {
    $cookie_name = $this->configuration['cookie_name'];
    $cookie_value = $this->configuration['cookie_value'];

    if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == $cookie_value) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

/**
 * Provides a human readable summary of the condition's configuration.
 */
 public function summary()
 {
     // @todo: Display summary
 }

}

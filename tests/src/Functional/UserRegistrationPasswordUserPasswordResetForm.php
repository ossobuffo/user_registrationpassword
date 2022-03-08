<?php

namespace Drupal\Tests\user_registrationpassword\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Core\Test\AssertMailTrait;
use Drupal\user\Form\UserPasswordForm;

/**
 * Functionality tests for User registration password module privacy feature.
 *
 * @group user_registrationpassword
 */
class UserRegistrationPasswordUserPasswordResetForm extends BrowserTestBase {

  use AssertMailTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = [
    'user_registrationpassword',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    global $base_url;
    $this->base_url = $base_url;
  }

  /**
   * Implements testUserRegistrationPasswordUserPasswordResetForm().
   */
  public function testUserRegistrationPasswordUserPasswordResetForm() {
    // Register a new account.
    $edit1 = [];
    $edit1['name'] = $this->randomMachineName();
    $edit1['mail'] = $edit1['name'] . '@example.com';
    $edit1['pass[pass1]'] = $new_pass = $this->randomMachineName();
    $edit1['pass[pass2]'] = $new_pass;
    $this->drupalGet('user/register');
    $this->submitForm($edit1, 'Create new account');
    $this->assertSession()->responseContains('A welcome message with further instructions has been sent to your email address.');

    // Request a new activation email.
    $edit2 = [];
    $edit2['name'] = $edit1['name'];
    $this->drupalGet('user/password');
    $this->submitForm($edit2, 'Submit');
    $this->assertSession()->responseContains('Further instructions have been sent to your email address.');

    $_emails = $this->getMails();
    $email = end($_emails);
    $this->assertNotEmpty($email['subject']);
    $this->assertNotEmpty($email['body']);
    $this->assertNotEquals($email['send'], 0);
  }

  /**
   * Implements testRegistrationFormDefaultValues().
   */
  public function testRegistrationFormDefaultValues() {
    // Load form object.
    $form_object = new UserPasswordForm(\Drupal::entityTypeManager()->getStorage('user'), \Drupal::languageManager(), \Drupal::configFactory(), \Drupal::flood());
    // Get the form array.
    $form = \Drupal::formBuilder()->getForm($form_object);

    // Test values.
    $this->assertEquals($form['#validate'][0], '_user_registrationpassword_user_pass_validate', 'Validate handler correctly changed.');
    $this->assertEquals($form['#submit'][0], '_user_registrationpassword_user_pass_submit', 'Submit handler correctly changed.');
  }
}

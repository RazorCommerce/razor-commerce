<?php
use \Razor\Core\Field\Field;
use \Core;

$form = Core::make('helper/form');
$u = new User;

$uEmail = false;
if( $u->isLoggedIn() ):
  $ui = UserInfo::getByID( $u->uID );
  $uEmail = $ui->uEmail;
endif;

?>

<!-- user login -->
<?php if( !$u->isLoggedIn() ): ?>
  <div class="row customer-login-toggle-wrap">
    <div class="col-xs-12">
      <!-- if user not logged in we provide them with login form -->
      <div class="customer-login-toggle">
        Returning customer? Click here to login >>
      </div>
      <div class="customer-login-form-wrap">
        <?php
          $standardAuth = AuthenticationType::getByHandle('concrete');
          $standardAuth->renderForm($authTypeElement ?: 'form', $authTypeParams ?: array());
        ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- open checkout form -->
<form action="<?php print $form->action( '/checkout/pay' ); ?>" id="checkout-form" method="post">
  <?php
    if( is_object( $order )) {
      print $form->hidden('order_id', $order->orderID );
      print $form->hidden('amount', $order->getTotal() );
    } else {
      print $form->hidden('order_id');
      print $form->hidden('amount');
    }
  ?>
  <?php  ?>
  <?php print $form->hidden('stripe_token'); ?>

<div class="row customer-pane">
  <div class="col-xs-12">
    <h2>Billing Details</h2>
  </div>

  <div class="col-xs-6">
    <?php print $form->label('first_name', 'First Name'); ?>
    <?php Field::render('first_name', 'user'); ?>
  </div>

  <div class="col-xs-6">
    <?php print $form->label('last_name', 'Last Name'); ?>
    <?php Field::render('last_name', 'user'); ?>
  </div>

  <div class="col-xs-6">
    <?php print $form->label('email', 'Email'); ?>
    <?php print $form->email('email', $uEmail ); ?>
  </div>

  <div class="col-xs-6">
    <?php print $form->label('phone', 'Phone'); ?>
    <?php Field::render('phone', 'user'); ?>
  </div>
</div>

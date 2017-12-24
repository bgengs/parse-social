<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Title</title>
    <style>
        body {
            width: 100%;
        }
        .main {
            width: 80%;
            margin: 0 auto;
        }

        .login-form {
            width: 300px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        .form-field {
            width: 100%;
            padding: 2px;
        }
        .form-field input {
            padding: 4px;
        }
    </style>
</head>
<body>
    <div class="main">

        <?php if ($app->session()->hasMessage()) : ?>
            <div>
                <?php print $app->session()->flush(); ?>
            </div>
        <?php endif; ?>

        <div class="login-form">
            <form action="/rasel/auth/login.php" method="post">

                <?php csrf_field(); ?>

<!--                for auth/login.php validation-->
                <input type="hidden" name="action" value="login">

<!--                for app/Handlers/Auth.php validation-->
                <input type="hidden" name="login" value="1">

                <fieldset>
                    <legend>Login</legend>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-field">
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-field">
                        <input type="submit" value="Login">
                    </div>
                </fieldset>
            </form>
            <div class="form-field">
                <button onclick="window.location.href='/register.php';">Register</button>
            </div>
            <div class="form-field">
                <form action="/rasel/auth/register.php" method="post">
			        <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="registration">
                    <input type="hidden" name="driver" value="facebook">
                    <button>Login with Facebook</button>
                </form>
            </div>
            <div class="form-field">
                <form action="/rasel/auth/register.php" method="post">
			        <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="registration">
                    <input type="hidden" name="driver" value="twitter">
                    <button>Login with Twitter</button>
                </form>
            </div>
            <div class="form-field">
                <form action="/rasel/auth/register.php" method="post">
			        <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="registration">
                    <input type="hidden" name="driver" value="linkedIn">
                    <button>Login with LinkedIn</button>
                </form>
            </div>
            <div class="form-field">
                <form action="/rasel/auth/register.php" method="post">
			        <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="registration">
                    <input type="hidden" name="driver" value="instagram">
                    <button>Login with Instagram</button>
                </form>
            </div>
            <div class="form-field">
                <form action="/rasel/auth/register.php" method="post">
			        <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="registration">
                    <input type="hidden" name="driver" value="github">
                    <button>Login with Github</button>
                </form>
            </div>
            <div class="form-field">
                <form action="/rasel/auth/register.php" method="post">
			        <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="registration">
                    <input type="hidden" name="driver" value="bitbucket">
                    <button>Login with Bitbucket</button>
                </form>
            </div>
            <div class="form-field">
                <form action="/rasel/auth/register.php" method="post">
			        <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="registration">
                    <input type="hidden" name="driver" value="google">
                    <button>Login with Google</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
use core\DataProvider;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasteIT</title>
    <link rel="stylesheet" href="./styles/facing.css">


    <script src="./scripts/chart.js"></script>

    <script>
        window.onload = function() {
            
            e1 = new Element(" Users", "#417333", "<?php echo DataProvider::numberOfUsers() ?>");
            e2 = new Element(" Public pastes", "#569944", "<?php echo DataProvider::numberOfPublicPastes() ?>");
            e3 = new Element(" Private pastes", "#569944", "<?php echo DataProvider::numberOfPrivatePastes() ?>");
            // e3 = new Element(" Visitors", "#3B692E", "20");
            elementList = Array();
            elementList.push(e1);
            elementList.push(e2);
            elementList.push(e3);
            createChart(40, 40, elementList, 80, 68);
        }
    </script>

</head>

<body itemscope itemtype="http://schema.org/WebPage">
    <section class="header">
        <div class="main-text">
            <h1>Paste It</h1>
            <p> Share your code now.</p>
            <a href="/home" class="get-started">Get Started</a>
        </div>
    </section>


    <section class="about">
        <h1 itemprop="headline">About Us</h1>
        <p>Paste It is a free online content hosting service where users
            can store souce code snippets for code review </p>
        <div class="account">
            <div itemprop="description" class="login-type">
                <h3 itemprop="headline">Having and account</h3>
                <p itemprop="description">If you already have an account then it's great!
                    You can share your code with unlimited time expiration.<br> You also
                    have at your disposal some great option that will help you a lot.
                    You cand protect your paste with a password for extra protection.

                </p>
            </div>

            <div itemprop="description" class="login-type">
                <h3 itemprop="headline">Don't have an account yet?</h3>
                <p itemprop="description">If you don't have an account yet, don't worry! Just click on "get started"
                    and create your account. Also if you want to just share your code
                    without an account, then you should consider that your paste are available only
                    for 30 days and you can only post public pastes. So, discover the best of this site by creating
                    your own account!
                </p>
            </div>
        </div>

        <div class="account">
            <div itemprop="description" class="login-type">
                <h3 itemprop="headline">Why would you choose our platform?</h3>
                <p>Our product is still in a incipient state and we consider that it has much potential.
                    The application dispose by ambiental animations, intuitive charts related to the activity
                    of the users and a plesant user interface.
                </p>
            </div>

            <div itemprop="description" class="login-type">
                <h3 itemprop="headline">Constraints?!</h3>
                <p>
                    With Paste It you can share your code without any limitations. There are no constraints about how many
                    pastes you can post. In fact, we have a future named "Burn after read" which make your paste to be seen only once.
                </p>
            </div>
        </div>
    </section>

    <!--third section about the site -->
    <section class="about">
        <h1 itemprop="headline">
            Paste It Statistics
        </h1>
        <p itemprop="description">If you're still thinking whether to use Paste It or not, then you should consider this:
            These are some statistics related to the activity of our users. We are convinced that this data would persuade you to come and join us</p>
        <div itemprop="interactionStatistic" class="statistics">
            <canvas width="500" height="500" id="myCanvas"></canvas>
        </div>


    </section>

    <div class="footer">
        <p>Copyright &copy; Paste IT</p>
        <p>Scholarly HTML <a href="./scholarly.html">HERE</a></p>
    </div>

</body>

</html>
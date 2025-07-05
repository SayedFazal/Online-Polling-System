<?php
session_start();
if (!isset($_SESSION['userdata'])) {
    header("location: ../");
    exit();
}
$userdata = $_SESSION['userdata'];
$photoPath = "../uploads/" . $userdata['photo'];
$groupsdata = $_SESSION['groupsdata'];

$status = ($userdata['status'] == 0) ? '<b style="color: red">Not voted</b>' : '<b style="color: green">Voted</b>';

$winnerGroup = null;
if (isset($_POST['publish'])) {
    $maxVotes = -1;
    foreach ($groupsdata as $group) {
        if ($group['votes'] > $maxVotes) {
            $maxVotes = $group['votes'];
            $winnerGroup = $group;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Online Polling System - Dashboard</title>
<link rel="stylesheet" href="../css/stylesheet.css" />
<link rel="icon" type="image/x-icon" href="logo.png" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #a1c4fd, #c2e9fb);
    }
    #backbtn, #logoutbtn, #votebtn, #voted, #publishBtn {
        padding: 8px 16px;
        font-size: 15px;
        border-radius: 6px;
        color: white;
        border: none;
    }
    #backbtn, #logoutbtn, #publishBtn {
        background-color: #3498db;
        margin: 15px;
        cursor: pointer;
    }
    #backbtn:hover, #logoutbtn:hover, #votebtn:hover, #publishBtn:hover {
        background-color: #2c80b4;
    }
    #backbtn { float: left; }
    #logoutbtn { float: right; }
    #votebtn { background-color: #3498db; }
    #voted { background-color: green; }

    #Profile {
        background-color: white;
        width: 100%;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        text-align: center;
        margin-bottom: 20px;
    }
    #Profile img {
        border-radius: 50%;
        border: 2px solid #3498db;
    }
    #Group {
        width: 100%;
    }
    .group-box {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }
    .group-box:hover {
        transform: scale(1.02);
    }
    .group-box img {
        height: 100px;
        width: 100px;
        border-radius: 10px;
        margin-left: 20px;
    }
    .group-info {
        flex-grow: 1;
    }
    .progress-bar-container {
        background-color: #ddd;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 5px;
    }
    .progress-bar {
        height: 20px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        line-height: 20px;
        font-size: 14px;
    }
    #popupOverlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 10000;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
    }
    #popupOverlay.active {
        display: flex;
    }
    #popup {
        position: relative;
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 5px 30px rgba(0,0,0,0.3);
        overflow: visible;
        z-index: 10001;
    }
    #confetti-container {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        pointer-events: none;
        z-index: 9999;
    }
    #popup img {
        max-width: 150px;
        border-radius: 10px;
        margin: 15px 0;
        position: relative;
        z-index: 10002;
    }
    #popup h2, #popup p {
        position: relative;
        z-index: 10002;
    }
    #popup button.close-btn {
        position: relative;
        z-index: 10002;
        padding: 8px 20px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    #popup button.close-btn:hover {
        background: #2c80b4;
    }
    @media (max-width: 768px) {
        #Profile, #Group {
            width: 100%;
            float: none;
            margin-bottom: 20px;
        }
    }
</style>
</head>
<body>

<div id="mainSection">
    <center>
        <div id="headerSection">
            <a href="../"><button id="backbtn"><i class="fas fa-arrow-left"></i> Back</button></a>
            <a href="logout.php"><button id="logoutbtn"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
            <h1>Online Polling System</h1>
        </div>
    </center>
    <hr>

    <div id="mainpanel">
        <?php if ($userdata['role'] == '1') { ?>
        <div id="Profile">
            <img src="<?php echo htmlspecialchars($photoPath); ?>" height="100" width="100" alt="User Photo" /><br /><br />
            <b>Name:</b> <?php echo htmlspecialchars($userdata['name']); ?><br /><br />
            <b>Mobile:</b> <?php echo htmlspecialchars($userdata['mobile']); ?><br /><br />
            <b>Address:</b> <?php echo htmlspecialchars($userdata['address']); ?><br /><br />
            <b>Status:</b> <?php echo $status; ?>
        </div>
        <?php } ?>

        <div id="Group">
            <?php
            foreach ($groupsdata as $group) {
                $groupPhoto = htmlspecialchars($group['photo']);
                $groupName = htmlspecialchars($group['name']);
                $groupVotes = (int)$group['votes'];
                $groupId = (int)$group['id'];
                $votePercentage = $groupVotes > 0 ? min(100, $groupVotes) : 1;
                ?>
                <div class="group-box">
                    <div class="group-info">
                        <b>Group Name:</b> <?php echo $groupName; ?><br /><br />
                        <b>Votes:</b> <?php echo $groupVotes; ?>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: <?php echo $votePercentage; ?>%;">
                                <?php echo $groupVotes; ?> Votes
                            </div>
                        </div><br />

                        <?php if ($userdata['role'] == '1') { ?>
                            <form action="../api/vote.php" method="POST">
                                <input type="hidden" name="gvotes" value="<?php echo $groupVotes; ?>" />
                                <input type="hidden" name="gid" value="<?php echo $groupId; ?>" />
                                <?php if ($userdata['status'] == 0): ?>
                                    <input type="submit" name="votebtn" value="Vote" id="votebtn" />
                                <?php else: ?>
                                    <button disabled type="button" id="voted">Voted</button>
                                <?php endif; ?>
                            </form>
                        <?php } ?>
                    </div>
                    <img src="../uploads/<?php echo $groupPhoto; ?>" alt="Group Photo" />
                </div>
            <?php }

            if ($userdata['role'] == '2') { ?>
                <form method="POST">
                    <button type="submit" name="publish" id="publishBtn">Publish Result</button>
                </form>
            <?php } ?>
        </div>
    </div>
</div>

<?php if (isset($winnerGroup)) { ?>
<div id="popupOverlay" class="active">
    <div id="popup">
        <div id="confetti-container"></div>
        <h2>🏆 Winner: <?php echo htmlspecialchars($winnerGroup['name']); ?></h2>
        <img src="../uploads/<?php echo htmlspecialchars($winnerGroup['photo']); ?>" alt="Winner Photo" />
        <p><strong>Total Votes:</strong> <?php echo $winnerGroup['votes']; ?></p>
        <button class="close-btn" id="closePopupBtn">Close</button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    var confettiInstance = confetti.create(document.getElementById('confetti-container'), {
        resize: true,
        useWorker: true
    });

    function fireConfetti() {
        var count = 200;
        var defaults = { origin: { y: 0.7 } };

        confettiInstance({ ...defaults, particleCount: Math.floor(count * 0.25), spread: 26, startVelocity: 55 });
        confettiInstance({ ...defaults, particleCount: Math.floor(count * 0.2), spread: 60 });
        confettiInstance({ ...defaults, particleCount: Math.floor(count * 0.35), spread: 100, decay: 0.91, scalar: 0.8 });
        confettiInstance({ ...defaults, particleCount: Math.floor(count * 0.1), spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
        confettiInstance({ ...defaults, particleCount: Math.floor(count * 0.1), spread: 120, startVelocity: 45 });
    }

    var confettiInterval = setInterval(fireConfetti, 1000);
    fireConfetti();

    function closePopup() {
        document.getElementById('popupOverlay').classList.remove('active');
        clearInterval(confettiInterval);
        confettiInstance.reset();
        window.location.href = 'dashboard.php'; // or logout.php if you want to log out
    }

    document.addEventListener('DOMContentLoaded', function() {
        var closeBtn = document.getElementById('closePopupBtn');
        if (closeBtn) {
            closeBtn.addEventListener('click', closePopup);
        }
    });
</script>
<?php } ?>

</body>
</html>

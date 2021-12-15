<!DOCTYPE html>
<?php 
// start a session
session_start();

// initialize session variables
$_SESSION['logged_in_user_id'] = '1';
$_SESSION['logged_in_user_name'] = 'Tutsplus';

// access session variables
// echo $_SESSION['logged_in_user_id'];
// echo $_SESSION['logged_in_user_name'];

// session_destroy();
?>

<?php

class BowlingGame {
    public $frame;
    public $score = [];

    function __construct(){
        $this->score = [];
    }

    public function frameScore(int $frame)
    {
        $this->setFrame($frame);
            //Strike
            
            if($this->getShot1($frame) === 10 && $this->getShot2($frame) === 0)
            {
                $this->strikeRule();
            }
            //Spare
            if($this->getShot1($frame) + $this->getShot2($frame) === 10)
            {
                $this->spareRule(10);
            }
            //Open frame
            if($this->getShot1($frame) + $this->getShot2($frame) <= 9)
            {
                $this->openFrameRule();
            }
            //Tehth frame
            // if strike first shot 2 more shots
            // if spare first two shots get 1 more shot
            // if open frame  game is over
            // total pins nokced during 10 frame

        //return $this->getScore();
    }

    public function rules(){

    }

    public function validateShoot(int $shot)
    {
        return $shot >= 0 && $shot <= 10 ? true : false;
    }

    public function strikeRule()
    {
        $frame = $this->getFrame();
        if($frame === 10){
            // $this->setScore()
        }
        if($frame > 1 && $frame < 9){
            $acum = $this->getScoreByFrame($frame-1) + $this->sumShot() + 10;
            $this->setScore($acum, $frame);
        }
        if($frame === 1){
            $this->setScore(10, $frame);
        }
    }

    public function sumShot()
    {
        $frame = $this->getFrame();
        return $this->getShot1($frame) + $this->getShot2($frame);
    }

    public function spareRule(){
        $frame = $this->getFrame();
        if($frame === 10){
            // $this->setScore()
        }
        if($frame > 1 && $frame < 9){
            $acum = $this->getScoreByFrame($frame-1) + $this->getShot1() + 10;
            $this->setScore($acum, $frame);
            $this->setScore(10, $frame+1);
        }
        if($frame === 1){
            $this->setScore(10, $frame);
            $this->setScore(10, $frame+1);
        }
    }

    public function openFrameRule()
    {
        return false;
    }

    public function tenthFrameRule(){
        return false;
    }

    public function setShot1(int $shot, int $frame)
    {
        if(!$this->validateShoot($shot))
        {
            return "Your shot can't be minor of 0 or mayor than 10\n";
        } 
        $this->score[$frame]['shot1'] = $shot;
    }
    public function setShot2(int $shot, int $frame)
    {
        if(!$this->validateShoot($shot))
        {
            return "Your shot can't be minor of 0 or mayor than 10\n";
        }
        $this->score[$frame]['shot2'] = $shot;
    }
    public function setFrame(int $frame)
    {
        $this->frame = $frame;
    }
    public function getFrame(): int
    {
        return $this->frame;
    }
    public function setScore(int $score, int $frame)
    {
        $this->score[$frame]['acum'] = $score;
    }
    public function getShot1(int $frame): int
    {
        return $this->score[$frame]['shot1'];
    }
    public function getShot2(int $frame): int
    {
        return $this->score[$frame]['shot2'];
    }
    public function getScoreByFrame(int $frame): int
    {
        return $this->score[$frame]['acum'];
    }
}

if(isset($_POST['frameNumber'])){
    $frameNumber = $_POST['frameNumber'];
    $shot1 = $_POST['shot1'];
    $shot2 = $_POST['shot2'];

    $game = new BowlingGame();

    $game->setShot1($shot1, $frameNumber);
    $game->setShot2($shot2, $frameNumber);
    $game->frameScore($frameNumber);    
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling One File</title>
</head>
<body>
    <div id="container">
        <form action="#" method="post">
            <button type="reset">New Game</button>
            <input type="text" name="frameNumber">
            <div><span>Score For Frame 1:</span><span><?php if(isset($_POST['frameNumber'])){ echo $game->getScoreByFrame($frameNumber); } ?></span></div>
            <div><span>Score For Frame 2:</span><span><?php ?></span></div>
            <div><span>Score For Frame 3:</span><span><?php ?></span></div>
            <label for="shot1">Shot 1</label>
            <input type="text" name="shot1" id="shot1">
            <label for="shot2">Shot 2</label>
            <input type="text" name="shot2" id="shot2">
            <button type="submit">Calculate Frame Score</button>
            <div><span>Final Score:</span><span><?php ?></span></div>
        </form>
    </div>
</body>
</html>
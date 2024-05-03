<html>
  <head>
    <title>PHP Roll</title>
  </head>
  <body>
<?php

class R
{
  private static $r=[];
  private static $z=[];
  private static $resCount = [-1 => 0, 0 => 0, 1 => 0];

  public function __construct()
  {
    $this->initz();
    $this->initbet();
  }

  private function initbet(): void
  {
      self::$r = array_map(
        fn () =>
          $this->rz()
          ? random_int(0, 1) 
            ? -1 
            : 1
          : 0,
        range(0, random_int(600, 900))
      );
  }

  private function initz(): void
  {
      self::$z = array_map(
        fn () => random_int(0, 37),
        range(0, random_int(37**2, 37**2+1))
      );
  }

  private function rz(): int
  {
    return self::$z[array_rand(self::$z)];
  }

  private function randy(): int
  {
    return self::$r[array_rand(self::$r)];
  }

  function run(
    int $nb_lance,
    int $dollars,
    int $bet,
    closure $strat
  ): void {
    $curBet = $bet;

    for ($i=0; $i<$nb_lance; $i++) {
      $res = $this->randy();
      self::$resCount[$res]++;

      // winlose
      if ($res === 1) {
        $dollars += $curBet * 2;
      } else {
        $dollars -= $curBet;
      }

      $strat($res, $curBet);
    }

    echo 'Reste ' . $dollars . '$';
  }
}

    $nb_lance = 100;
    $dollars = 1000;
    $bet = 1;
    $strat = function (int $res, int &$curBet) {
      if ($res === 1) {
        $curBet++;
      } else {
        if ($curBet > 1) $curBet--;
      }
    };
(new R())->run($nb_lance, $dollars, $bet, $strat);
?>
</html>
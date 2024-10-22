<?php namespace App;

class Statline
{
    private int $m, $ws, $bs, $s, $t, $w, $i, $a, $ld;

    public function __construct(int $m, int $ws, int $bs, int $s, int $t, int $w, int $i, int $a, int $ld)
    {
        $this->m = $m;
        $this->ws = $ws;
        $this->bs = $bs;
        $this->s = $s;
        $this->t = $t;
        $this->w = $w;
        $this->i = $i;
        $this->a = $a;
        $this->ld = $ld;
    }

    public function getStat(string $stat): int
    {
        return $this->$stat;
    }

    public static function builder()
    {
        return new StatlineBuilder();
            
    }
}

class StatlineBuilder
{
    private int $m, $ws, $bs, $s, $t, $w, $i, $a, $ld;

    public function build()
    {
        return new Statline(...get_object_vars($this));
    }

    public function m(int $m): self
    {
        $this->m = $m;
        return $this;
    }

    public function ws(int $ws): self
    {
        $this->ws = $ws;
        return $this;
    }

    public function bs(int $bs): self
    {
        $this->bs = $bs;
        return $this;
    }

    public function s(int $s): self
    {
        $this->s = $s;
        return $this;
    }

    public function t(int $t): self
    {
        $this->t = $t;
        return $this;
    }

    public function w(int $w): self
    {
        $this->w = $w;
        return $this;
    }

    public function i(int $i): self
    {
        $this->i = $i;
        return $this;
    }

    public function a(int $a): self
    {
        $this->a = $a;
        return $this;
    }

    public function ld(int $ld): self
    {
        $this->ld = $ld;
        return $this;
    }
}
<?php
namespace Troiswa\PublicBundle\Services\Twig;

class Monmien extends \Twig_extension
{
    public function getName()
    {
        return '';
    }

    public function getFilters()
    {
        return array( 'age' => new \Twig_SimpleFilter( 'age', array( $this, 'getAge' ) ),
            'visible' => new \Twig_SimpleFilter( 'visible', array( $this, 'getVisible' ) )
        );
    }

    public function getFunctions()
    {
        return array( 'price' => new \Twig_SimpleFunction( 'price', array( $this, 'getPrice' ) ),

        );
    }

    public function getPrice($prix, $decimal = 0, $separator = ',', $monnaie = '€')
    {
        $price = number_format($prix, $decimal, $separateur, ' ');

        return $price . '' . $monnaie;
    }

    public function getAge($acteur)
    {

    }

}

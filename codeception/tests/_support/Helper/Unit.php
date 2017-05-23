<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
{

    public function call_method( $obj, $name, array $args ) {
        $class  = new \ReflectionClass( $obj );
        $method = $class->getMethod( $name );
        $method->setAccessible( true );

        return $method->invokeArgs( $obj, $args );
    }

    /**
     * Get a private or protected method for testing/documentation purposes.
     * How to use for MyClass->foo():
     *      $cls = new MyClass();
     *      $foo = PHPUnit_Util::get_private_method($cls, 'foo');
     *      $foo->invoke($cls, $...);
     *
     * @param object $obj The instantiated instance of your class
     * @param string $name The name of your private/protected method
     *
     * @return ReflectionMethod The method you asked for
     */
    public function get_private_method( $obj, $name ) {
        $class  = new \ReflectionClass( $obj );
        $method = $class->getMethod( $name );
        $method->setAccessible( true );

        return $method;
    }


    //  public static function set_private_property_value( $obj, $name, $val ){
    //      $class  = new \ReflectionClass( $obj );
    //      $property = $class->getProperty( $name );
    //      $property->setAccessible(true);
    //      $property->setValue( $obj, $val );
    //      return $class;
    //  }
    //
    //  public static function get_private_property( $obj, $name ){
    //      $class  = new \ReflectionClass( $obj );
    //      $property = $class->getProperty( $name );
    //      $property->setAccessible( true );
    //      return $property;
    //  }

}

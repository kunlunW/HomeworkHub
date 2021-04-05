<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once '..\backend\backend_functions.php';
require_once '..\backend\table_operations.php';

/**
 * @codeCoverageIgnore
 */
final class BackendTest extends TestCase
{ 
    protected function setUp(): void
    {
        ResetTables();
    }   

    public static function tearDownAfterClass(): void
    {
        ResetTables();
    }

    public function testRetrieveUserFromEmptyTable(): void
    {
        $expected = 2;
        $actual = RetrieveUser("Amy", "Long");
        $this->assertEquals($expected, $actual);
    }

    public function testAddUserToEmptyTable(): void
    {
        $expected = 0;
        $actual = AddUser("Ben", "Reas", 'parent');
        $this->assertEquals($expected, $actual);
    }

    public function testAddDuplicateUsers(): void
    {
        $expected = 0;
        $actual = AddUser("Amy", "Long", 'teacher');
        $this->assertEquals($expected, $actual);

        $expected = 2;
        $actual = AddUser("Amy", "Long", 'teacher');
        $this->assertEquals($expected, $actual);
    }

    public function testAddMultipleUsers(): void
    {
        $expected = 0;
        $actual = AddUser("Amy", "Long", 'teacher');
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = AddUser("Ben", "Reas", 'teacher');
        $this->assertEquals($expected, $actual);
        
        $expected = 0;
        $actual = AddUser("Tony", "Zimmer", 'parent');
        $this->assertEquals($expected, $actual);
    }

    public function testAddMultipleUsersAndThenADuplicate(): void
    {
        $expected = 0;
        $actual = AddUser("Amy", "Long", 'teacher');
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = AddUser("Ben", "Reas", 'teacher');
        $this->assertEquals($expected, $actual);
        
        $expected = 0;
        $actual = AddUser("Tony", "Zimmer", 'parent');
        $this->assertEquals($expected, $actual);

        $expected = 2;
        $actual = AddUser("Ben", "Reas", 'teacher');
        $this->assertEquals($expected, $actual);
    }

    public function testAddUsersOfDifferentTypes(): void
    {
        $expected = 0;
        $actual = AddUser("Ben", "Reas", 'teacher');
        $this->assertEquals($expected, $actual);
        
        $expected = 2;
        $actual = AddUser("Ben", "Reas", 'parent');
        $this->assertEquals($expected, $actual);
    }

    public function testAddAndRetrieveUser(): void
    {
        $expected = 0;
        $actual = AddUser("Ben", "Reas", 'teacher');
        $this->assertEquals($expected, $actual);
        
        $expected = 'teacher';
        $actual = RetrieveUser("Ben", "Reas");
        $this->assertEquals($expected, $actual);
    }

    public function testCreateClassroom(): void
    {
        AddUser("Fred", "pass", 'teacher');

        $expected = 1;
        $actual = CreateClassroom("Biology", "Fred");
        $this->assertEquals($expected, $actual);
    }

    public function testCreateMultipleClassrooms(): void
    {
        AddUser("Jim", "pass", 'teacher');
        AddUser("Fred", "pass", 'teacher');

        $expected = 1;
        $actual = CreateClassroom("Biology", "Fred");
        $this->assertEquals($expected, $actual);

        $expected = 2;
        $actual = CreateClassroom("Math", "Fred");
        $this->assertEquals($expected, $actual);

        $expected = 3;
        $actual = CreateClassroom("Biology", "Jim");
        $this->assertEquals($expected, $actual);

    }

    public function testCreateClassroomViolateForeignKeyConstraint(): void
    {
        $expected = 0;
        $actual = CreateClassroom("Biology", "Fred");
        $this->assertEquals($expected, $actual);
    }

}
?>

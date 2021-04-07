<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once '..\backend\backend_functions.php';
require_once '..\backend\table_operations.php';

/**
 * @codeCoverageIgnore
 */
final class BackendTest extends TestCase
{ 
    
    public static function setUpBeforeClass(): void
    {
        ResetTables();
    }

    protected function setUp(): void
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

    public function testRetrieveUserWithWrongPassword(): void
    {
        $expected = 0;
        $actual = AddUser("Ben", "Reas", 'teacher');
        $this->assertEquals($expected, $actual);
        
        $expected = 2;
        $actual = RetrieveUser("Ben", "Pass");
        $this->assertEquals($expected, $actual);
    }

    public function testRetrieveUserWithWrongUsername(): void
    {
        $expected = 0;
        $actual = AddUser("Ben", "Reas", 'teacher');
        $this->assertEquals($expected, $actual);
        
        $expected = 2;
        $actual = RetrieveUser("Benny", "Reas");
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

    public function testGetEmptyClassroomList(): void
    {
        $expected = "[]";
        $actual = GetTeacherClassrooms("Fred");
        $this->assertEquals($expected, $actual);
    }

    public function testGetClassroomListWith1Element(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Math", "Tom");

        $expected = '[{"classroomid":1, "classroomname":"Math", "teachername":"Tom"}]';
        $actual = GetTeacherClassrooms("Tom");
        $this->assertEquals($expected, $actual);
    }

    public function testGetClassroomListWithManyElements(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom");
        CreateClassroom("History", "Tom");
        CreateClassroom("Math", "Tom");

        $expected = '[{"classroomid":1, "classroomname":"Science", "teachername":"Tom"},' . 
            '{"classroomid":2, "classroomname":"History", "teachername":"Tom"},' .
            '{"classroomid":3, "classroomname":"Math", "teachername":"Tom"}]';
        $actual = GetTeacherClassrooms("Tom");
        $this->assertEquals($expected, $actual);
    }

    public function testCreateOneRequest(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("John", "George", "parent");
        CreateClassroom("Science", "Tom");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testCreateMultipleRequestsToSameClassroom(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("Amy", "Long", "parent");
        AddUser("Ash", "Ketchum", "parent");
        AddUser("John", "George", "parent");
        CreateClassroom("Science", "Tom");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = CreateRequest("Amy", 1);
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = CreateRequest("Ash", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testCreateMultipleRequestsToDifferentClassrooms(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("Amy", "Long", "teacher");
        AddUser("Ash", "Ketchum", "teacher");
        AddUser("John", "George", "parent");
        CreateClassroom("Math", "Tom");
        CreateClassroom("History", "Amy");
        CreateClassroom("Science", "Ash");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = CreateRequest("John", 2);
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = CreateRequest("John", 3);
        $this->assertEquals($expected, $actual);
    }

    public function testCreateDuplicateRequests(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("John", "George", "parent");
        CreateClassroom("Math", "Tom");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = 4;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testRequestToJoinClassroomAlreadyIn(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("John", "George", "parent");
        CreateClassroom("Math", "Tom");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);

        AcceptRequest("John", 1);

        $expected = 3;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testRequestWithInvalidUsername(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Math", "Tom");

        $expected = 1;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testRequestWithInvalidCid(): void
    {
        AddUser("Tom", "Stone", "parent");

        $expected = 2;
        $actual = CreateRequest("Tom", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testAcceptRequest(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("John", "George", "parent");
        CreateClassroom("Math", "Tom");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = AcceptRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = 3;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testAcceptRequestTwice(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("John", "George", "parent");
        CreateClassroom("Math", "Tom");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = AcceptRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = AcceptRequest("John", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testAcceptRequestOnlyChangesOneRequest(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("Jim", "stan", "parent");
        AddUser("John", "George", "parent");
        CreateClassroom("Math", "Tom");

        $expected = 0;
        $actual = CreateRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = '[{"username":"John"}]';
        $actual = GetPendingRequests(1);
        $this->assertEquals($expected, $actual);
        
        $expected = 0;
        $actual = CreateRequest("Jim", 1);
        $this->assertEquals($expected, $actual);

        $expected = '[{"username":"Jim"},{"username":"John"}]';
        $actual = GetPendingRequests(1);
        $this->assertEquals($expected, $actual);
        
        $expected = 0;
        $actual = AcceptRequest("John", 1);
        $this->assertEquals($expected, $actual);

        $expected = '[{"username":"Jim"}]';
        $actual = GetPendingRequests(1);
        $this->assertEquals($expected, $actual);
    }

}
?>

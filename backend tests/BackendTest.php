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
        $actual = CreateClassroom("Biology", "Fred", "a");
        $this->assertEquals($expected, $actual);
    }

    public function testCreateMultipleClassrooms(): void
    {
        AddUser("Jim", "pass", 'teacher');
        AddUser("Fred", "pass", 'teacher');

        $expected = 1;
        $actual = CreateClassroom("Biology", "Fred", "a");
        $this->assertEquals($expected, $actual);

        $expected = 2;
        $actual = CreateClassroom("Math", "Fred", "b");
        $this->assertEquals($expected, $actual);

        $expected = 3;
        $actual = CreateClassroom("Biology", "Jim", "c");
        $this->assertEquals($expected, $actual);

    }

    public function testCreateClassroomViolateForeignKeyConstraint(): void
    {
        $expected = 0;
        $actual = CreateClassroom("Biology", "Fred", "a");
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
        CreateClassroom("Math", "Tom", "a");

        $expected = '[{"classroomid":1, "classroomname":"Math", "joincode":"a", "teachername":"Tom"}]';
        $actual = GetTeacherClassrooms("Tom");
        $this->assertEquals($expected, $actual);
    }

    public function testGetClassroomListWithManyElements(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateClassroom("History", "Tom", "b");
        CreateClassroom("Math", "Tom", "c");

        $expected = '[{"classroomid":1, "classroomname":"Science", "joincode":"a", "teachername":"Tom"},' . 
            '{"classroomid":2, "classroomname":"History", "joincode":"b", "teachername":"Tom"},' .
            '{"classroomid":3, "classroomname":"Math", "joincode":"c", "teachername":"Tom"}]';
        $actual = GetTeacherClassrooms("Tom");
        $this->assertEquals($expected, $actual);
    }
// TODO start here
    public function testCreateTestEvent(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 1;
        $actual = CreateTest("name", "desc", "2021-12-25", 100, 45, 1);
        $this->assertEquals($expected, $actual);
    }

    public function testCreateHomeworkEvent(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 1;
        $actual = CreateHomework("name", "desc", "2021-12-25", 100, 1);
        $this->assertEquals($expected, $actual);
    }

/*    public function testCreateAnnouncementEvent(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 1;
        $actual = CreateEvent("name", "desc", "2021-12-25", 1, "announcement");
        $this->assertEquals($expected, $actual);
    } */

    public function testCreateHomeworkWithInvalidCid(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 2;
        $actual = CreateHomework("name", "desc", "2021-12-25", 100, 2);
        $this->assertEquals($expected, $actual);
    }

    public function testCreateTestWithInvalidCid(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 2;
        $actual = CreateTest("name", "desc", "2021-12-25", 100, 60, 2);
        $this->assertEquals($expected, $actual);
    }

    /*
    public function testCreateEventWithInvalidDueDate(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom");

        $expected = 4;
        $actual = CreateEvent("name", "desc", "2021-ref-4", 1, "announcement");
        $this->assertEquals($expected, $actual);
    }
    */

    public function testCreateMultipleEvents(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 1;
        $actual = CreateTest("name", "desc", "2021-12-25", 20, 15, 1);
        $this->assertEquals($expected, $actual);
        /* 
        $expected = 2;
        $actual = CreateEvent("name1", "desc1", "2021-11-25", 1, "announcement");
        $this->assertEquals($expected, $actual); 
        */
        $expected = 1;
        $actual = CreateHomework("name2", "desc2", "2021-04-26", 50, 1);
        $this->assertEquals($expected, $actual); 
    
    }

    public function testCreateAndGetHomework(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateHomework("name", "desc", "2021-12-25", 25, 1);

        $expected = '[{"homeworkid":1, "name":"name", "description":"desc", "duedate":"2021-12-25", "points":25}]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testCreateAndGetTest(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateTest("name", "desc", "2021-12-25", 30, 30, 1);

        $expected = '[{"testid":1, "name":"name", "description":"desc", "duedate":"2021-12-25", "points":30, "timelimit":30}]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
    }

    public function testCreateAndGetMultipleHomeworks(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateHomework("name1", "desc1", "2021-01-25", 1, 1); 
        CreateHomework("name2", "desc2", "2021-02-25", 2, 1); 
        CreateHomework("name3", "desc3", "2021-03-25", 3, 1); 
        
        $expected = '[{"homeworkid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":1},' .
        '{"homeworkid":2, "name":"name2", "description":"desc2", "duedate":"2021-02-25", "points":2},' .
        '{"homeworkid":3, "name":"name3", "description":"desc3", "duedate":"2021-03-25", "points":3}]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testCreateAndGetMultipleTests(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateTest("name1", "desc1", "2021-01-25", 1, 1, 1); 
        CreateTest("name2", "desc2", "2021-02-25", 2, 2, 1);
        CreateTest("name3", "desc3", "2021-03-25", 3, 3, 1);
        
        $expected = '[{"testid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":1, "timelimit":1},' .
        '{"testid":2, "name":"name2", "description":"desc2", "duedate":"2021-02-25", "points":2, "timelimit":2},' .
        '{"testid":3, "name":"name3", "description":"desc3", "duedate":"2021-03-25", "points":3, "timelimit":3}]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyHomeworkList(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = '[]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyTestList(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = '[]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetCorrectTypeEvents(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateHomework("name1", "desc1", "2021-01-25", 1, 1); 
        CreateTest("name2", "desc2", "2021-02-25", 5, 15, 1);
        CreateHomework("name3", "desc3", "2021-03-25", 3, 1);
        
        $expected = '[{"homeworkid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":1},' .
        '{"homeworkid":2, "name":"name3", "description":"desc3", "duedate":"2021-03-25", "points":3}]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);

        $expected = '[{"testid":1, "name":"name2", "description":"desc2", "duedate":"2021-02-25", "points":5, "timelimit":15}]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
    }

    public function testUpdateHomework(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateHomework("name1", "desc1", "2021-01-25", 100, 1); 
        
        $expected = '[{"homeworkid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":100}]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = UpdateHomework(1, "name2", "desc2", "2021-02-26", 50);
        $this->assertEquals($expected, $actual);
    
        $expected = '[{"homeworkid":1, "name":"name2", "description":"desc2", "duedate":"2021-02-26", "points":50}]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
        
    }

    public function testUpdateTest(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateTest("name1", "desc1", "2021-01-25", 20, 20, 1); 
        
        $expected = '[{"testid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":20, "timelimit":20}]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = UpdateTest(1, "name2", "desc2", "2021-02-26", 30, 30);
        $this->assertEquals($expected, $actual);
    
        $expected = '[{"testid":1, "name":"name2", "description":"desc2", "duedate":"2021-02-26", "points":30, "timelimit":30}]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
        
    }

    public function testUpdateNonexistentHomework(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateHomework("name1", "desc1", "2021-01-25", 20, 1); 
        
        $expected = 1;
        $actual = UpdateHomework(2, "name2", "desc2", "2021-02-26", 50);
        $this->assertEquals($expected, $actual);
    
        $expected = '[{"homeworkid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":20}]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
        
    }
 
    public function testUpdateNonexistentTest(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateTest("name1", "desc1", "2021-01-25", 50, 100, 1); 
        
        $expected = 1;
        $actual = UpdateTest(2, "name2", "desc2", "2021-02-26", 20, 20);
        $this->assertEquals($expected, $actual);
    
        $expected = '[{"testid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":50, "timelimit":100}]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
        
    }
 
    public function testDeleteHomework(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateHomework("name1", "desc1", "2021-01-25", 20, 1); 
        
        $expected = '[{"homeworkid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":20}]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = DeleteEvent(1, "homework");
        $this->assertEquals($expected, $actual);
    
        $expected = '[]';
        $actual = GetEventList(1, "homework");
        $this->assertEquals($expected, $actual);
        
    }

    public function testDeleteTest(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateTest("name1", "desc1", "2021-01-25", 10, 60, 1); 
        
        $expected = '[{"testid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25", "points":10, "timelimit":60}]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = DeleteEvent(1, "test");
        $this->assertEquals($expected, $actual);
    
        $expected = '[]';
        $actual = GetEventList(1, "test");
        $this->assertEquals($expected, $actual);
        
    }

}
?>

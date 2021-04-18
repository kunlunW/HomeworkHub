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

    public function testCreateAnnouncementEvent(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 1;
        $actual = CreateAnnouncement("name", "desc", "2021-12-25", 1);
        $this->assertEquals($expected, $actual);
    } 

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

    public function testCreateAnnouncementWithInvalidCid(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 2;
        $actual = CreateAnnouncement("name", "desc", "2021-12-25", 2);
        $this->assertEquals($expected, $actual);
    }

    public function testCreateMultipleEvents(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = 1;
        $actual = CreateTest("name", "desc", "2021-12-25", 20, 15, 1);
        $this->assertEquals($expected, $actual);
        
        $expected = 1;
        $actual = CreateHomework("name2", "desc2", "2021-04-26", 50, 1);
        $this->assertEquals($expected, $actual); 
    
        $expected = 1;
        $actual = CreateAnnouncement("name2", "desc2", "2021-04-26", 1);
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

    public function testCreateAndGetAnnouncement(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateAnnouncement("name", "desc", "2021-12-25", 1);

        $expected = '[{"announcementid":1, "name":"name", "description":"desc", "duedate":"2021-12-25"}]';
        $actual = GetEventList(1, "announcement");
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

    public function testCreateAndGetMultipleAnnouncements(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateAnnouncement("name1", "desc1", "2021-01-25", 1); 
        CreateAnnouncement("name2", "desc2", "2021-02-25", 1);
        CreateAnnouncement("name3", "desc3", "2021-03-25", 1);
        
        $expected = '[{"announcementid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25"},' .
        '{"announcementid":2, "name":"name2", "description":"desc2", "duedate":"2021-02-25"},' .
        '{"announcementid":3, "name":"name3", "description":"desc3", "duedate":"2021-03-25"}]';
        $actual = GetEventList(1, "announcement");
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

    public function testGetEmptyAnnouncementList(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");

        $expected = '[]';
        $actual = GetEventList(1, "announcement");
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

    public function testUpdateAnnouncement(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateAnnouncement("name1", "desc1", "2021-01-25", 1); 
        
        $expected = '[{"announcementid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25"}]';
        $actual = GetEventList(1, "announcement");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = UpdateAnnouncement(1, "name2", "desc2", "2021-02-26");
        $this->assertEquals($expected, $actual);
    
        $expected = '[{"announcementid":1, "name":"name2", "description":"desc2", "duedate":"2021-02-26"}]';
        $actual = GetEventList(1, "announcement");
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
 
    public function testUpdateNonexistentAnnouncement(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateAnnouncement("name1", "desc1", "2021-01-25", 1); 
        
        $expected = 1;
        $actual = UpdateAnnouncement(2, "name2", "desc2", "2021-02-26");
        $this->assertEquals($expected, $actual);
    
        $expected = '[{"announcementid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25"}]';
        $actual = GetEventList(1, "announcement");
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

    public function testDeleteAnnouncement(): void
    {
        AddUser("Tom", "Stone", "teacher");
        CreateClassroom("Science", "Tom", "a");
        CreateAnnouncement("name1", "desc1", "2021-01-25", 1); 
        
        $expected = '[{"announcementid":1, "name":"name1", "description":"desc1", "duedate":"2021-01-25"}]';
        $actual = GetEventList(1, "announcement");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = DeleteEvent(1, "announcement");
        $this->assertEquals($expected, $actual);
    
        $expected = '[]';
        $actual = GetEventList(1, "announcement");
        $this->assertEquals($expected, $actual);
        
    }

    public function testJoinClassroom(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        CreateClassroom("Science", "Tom", "a");

        $expected = 0;
        $actual = JoinClassroom("James", "a");
        $this->assertEquals($expected, $actual);
    }

    public function testMultiplePeopleJoinClassroom(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        AddUser("Roger", "Kane", "parent");
        AddUser("Ben", "Reas", "parent");
        CreateClassroom("Science", "Tom", "a");

        $expected = 0;
        $actual = JoinClassroom("James", "a");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = JoinClassroom("Roger", "a");
        $this->assertEquals($expected, $actual);
    
        $expected = 0;
        $actual = JoinClassroom("Ben", "a");
        $this->assertEquals($expected, $actual);
    }

    public function testJoinClassroomWithInvalidJoinCode(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        CreateClassroom("Science", "Tom", "a");

        $expected = 1;
        $actual = JoinClassroom("James", "b");
        $this->assertEquals($expected, $actual);
    }

    public function testJoinClassroomWithInvalidUsername(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        CreateClassroom("Science", "Tom", "a");

        $expected = 2;
        $actual = JoinClassroom("Charles", "a");
        $this->assertEquals($expected, $actual);
    }

    public function testJoinClassroomWithSameUserTwice(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        CreateClassroom("Science", "Tom", "a");

        $expected = 0;
        $actual = JoinClassroom("James", "a");
        $this->assertEquals($expected, $actual);
    
        $expected = 3;
        $actual = JoinClassroom("James", "a");
        $this->assertEquals($expected, $actual); 
    }

    public function testJoinClassroomWithTeacher(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        CreateClassroom("Science", "Tom", "a");

        $expected = 4;
        $actual = JoinClassroom("Tom", "a");
        $this->assertEquals($expected, $actual);
    }
 

    public function testLeaveClassroom(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        CreateClassroom("Science", "Tom", "a");
        JoinClassroom("James", "a");

        $expected = 0;
        $actual = LeaveClassroom("James", 1);
        $this->assertEquals($expected, $actual);
    }

    public function testretrieveclassroomlistwithoneparent(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        JoinClassroom("james", "a");

        $expected = '["james"]';
        $actual = GetAllParentsInClassroom(1);
        $this->assertEquals($expected, $actual);
    }

    public function testRetrieveClassroomListWithMultipleParents(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        AddUser("Roger", "Kane", "parent");
        AddUser("Ben", "Reas", "parent");
        CreateClassroom("Science", "Tom", "a");
        JoinClassroom("James", "a");
        JoinClassroom("Roger", "a");
        JoinClassroom("Ben", "a");

        $expected = '["Ben","James","Roger"]';
        $actual = GetAllParentsInClassroom(1);
        $this->assertEquals($expected, $actual);
    }

    public function testRetrieveEmptyClassroomList(): void
    {
        AddUser("Tom", "Stone", "teacher");
        AddUser("James", "Smith", "parent");
        CreateClassroom("Science", "Tom", "a");

        $expected = '[]';
        $actual = GetAllParentsInClassroom(1);
        $this->assertEquals($expected, $actual);
    }

    public function testretrieveParentClassroomListWithOneClassroom(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        JoinClassroom("james", "a");

        $expected = '[1]';
        $actual = GetAllClassroomsForParent("james");
        $this->assertEquals($expected, $actual);
    }

    public function testretrieveParentClassroomListWithMultipleClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("math", "tom", "b");
        CreateClassroom("history", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");

        $expected = '[1,2,3]';
        $actual = GetAllClassroomsForParent("james");
        $this->assertEquals($expected, $actual);
    }
    
    public function testretrieveEmptyParentClassroomList(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("math", "tom", "b");
        CreateClassroom("history", "tom", "c");

        $expected = '[]';
        $actual = GetAllClassroomsForParent("james");
        $this->assertEquals($expected, $actual);
    }

    public function testAddTeacherInformation(): void
    {
        AddUser("tom", "stone", "teacher");

        $expected = 3;
        $actual = UpdateTeachersInfo("tom", 'male', "tom@wisc.edu", 1234567890, "Madison School");
        $this->assertEquals($expected, $actual);
    }

    public function testUpdateTeacherInformation(): void
    {
        AddUser("tom", "stone", "teacher");

        $expected = 3;
        $actual = UpdateTeachersInfo("tom", 'male', "tom@wisc.edu", 1234567890, "Madison School");
        $this->assertEquals($expected, $actual);
   
        $expected = 1;
        $actual = UpdateTeachersInfo("tom", 'male', "tom@wisc.edu", 515, "Madison School");
        $this->assertEquals($expected, $actual);
    }

    public function testAddTeacherInformationWithInvalidUser(): void
    {
        AddUser("tom", "stone", "teacher");

        $expected = 2;
        $actual = UpdateTeachersInfo("Tony", 'other', "tom@wisc.edu", 1234567890, "Madison School");
        $this->assertEquals($expected, $actual);
    }
 

    public function testGetNonExistantTeacherInformation(): void
    {
        AddUser("tom", "stone", "teacher");

        $expected = 1;
        $actual = DisplayTeacherInfo("tom");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherInformation(): void
    {
        AddUser("tom", "stone", "teacher");
        UpdateTeachersInfo("tom", 'male', "tom@wisc.edu", 1234567890, "Madison School");

        $expected = '[{"gender":"male", "email":"tom@wisc.edu", "mobile_no":"1234567890", "school":"Madison School"}]';
        $actual = DisplayTeacherInfo("tom");
        $this->assertEquals($expected, $actual);
    }

    public function testGetHomeworkListWithOneElementFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        CreateHomework("name2", "desc2", "2021-12-26", 20, 2);
        
        $expected = '[{"homeworkid":1, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "classroomid":2}]';
        $actual = GetParentEventListForAllClassrooms("james", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetHomeworkListWithMultipleElementsFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        CreateHomework("name1", "desc1", "2021-12-25", 10, 1);
        CreateHomework("name2", "desc2", "2021-12-26", 20, 2);
        CreateHomework("name3", "desc3", "2021-12-27", 30, 3);
        
        $expected = '[{"homeworkid":1, "name":"name1", "description":"desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"name3", "description":"desc3", "duedate":"2021-12-27", "points":30, "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyHomeworkListFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        
        $expected = '[]';
        $actual = GetParentEventListForAllClassrooms("james", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTestListWithOneElementFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        CreateTest("name2", "desc2", "2021-12-26", 20, 45, 2);
        
        $expected = '[{"testid":1, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "timelimit":45, "classroomid":2}]';
        $actual = GetParentEventListForAllClassrooms("james", "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTestListWithMultipleElementsFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        CreateTest("name1", "desc1", "2021-12-25", 10, 30, 1);
        CreateTest("name2", "desc2", "2021-12-26", 20, 45, 2);
        CreateTest("name3", "desc3", "2021-12-27", 30, 60, 3);
        
        $expected = '[{"testid":1, "name":"name1", "description":"desc1", "duedate":"2021-12-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"name3", "description":"desc3", "duedate":"2021-12-27", "points":30, "timelimit":60, "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyTestListFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        
        $expected = '[]';
        $actual = GetParentEventListForAllClassrooms("james", "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetAnnouncementListWithOneElementFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        CreateAnnouncement("name2", "desc2", "2021-12-26", 2);
        
        $expected = '[{"announcementid":1, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "classroomid":2}]';
        $actual = GetParentEventListForAllClassrooms("james", "announcement");
        $this->assertEquals($expected, $actual);
    }

    public function testGetAnnouncementListWithMultipleElementsFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        CreateAnnouncement("name1", "desc1", "2021-12-25", 1);
        CreateAnnouncement("name2", "desc2", "2021-12-26", 2);
        CreateAnnouncement("name3", "desc3", "2021-12-27", 3);
        
        $expected = '[{"announcementid":1, "name":"name1", "description":"desc1", "duedate":"2021-12-25", "classroomid":1},' .
            '{"announcementid":2, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"name3", "description":"desc3", "duedate":"2021-12-27", "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "announcement");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyAnnouncementListFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        
        $expected = '[]';
        $actual = GetParentEventListForAllClassrooms("james", "announcement");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEventListFromAllClassroomsReturnsCorrectEvents(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        CreateAnnouncement("a_name1", "a_desc1", "2021-10-25", 1);
        CreateAnnouncement("a_name2", "a_desc2", "2021-10-26", 2);
        CreateAnnouncement("a_name3", "a_desc3", "2021-10-27", 3);
        CreateTest("t_name1", "t_desc1", "2021-11-25", 10, 30, 1);
        CreateTest("t_name2", "t_desc2", "2021-11-26", 20, 45, 2);
        CreateTest("t_name3", "t_desc3", "2021-11-27", 30, 60, 3);
        CreateHomework("h_name1", "h_desc1", "2021-12-25", 10, 1);
        CreateHomework("h_name2", "h_desc2", "2021-12-26", 20, 2);
        CreateHomework("h_name3", "h_desc3", "2021-12-27", 30, 3);
        
        $expected = '[{"announcementid":1, "name":"a_name1", "description":"a_desc1", "duedate":"2021-10-25", "classroomid":1},' .
            '{"announcementid":2, "name":"a_name2", "description":"a_desc2", "duedate":"2021-10-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"a_name3", "description":"a_desc3", "duedate":"2021-10-27", "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":1, "name":"t_name1", "description":"t_desc1", "duedate":"2021-11-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"t_name2", "description":"t_desc2", "duedate":"2021-11-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"t_name3", "description":"t_desc3", "duedate":"2021-11-27", "points":30, "timelimit":60, "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":1, "name":"h_name1", "description":"h_desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"h_name2", "description":"h_desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"h_name3", "description":"h_desc3", "duedate":"2021-12-27", "points":30, "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEventListFromAllClassroomsDoesNotReturnEventsInOtherClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        AddUser("Al", "Jordan", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateClassroom("english", "tom", "d");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        JoinClassroom("james", "c");
        JoinClassroom("Al", "d");
        CreateAnnouncement("a_name1", "a_desc1", "2021-10-25", 1);
        CreateAnnouncement("a_name2", "a_desc2", "2021-10-26", 2);
        CreateAnnouncement("a_name3", "a_desc3", "2021-10-27", 3);
        CreateAnnouncement("a_name4", "a_desc4", "2021-10-28", 4);
        CreateTest("t_name1", "t_desc1", "2021-11-25", 10, 30, 1);
        CreateTest("t_name2", "t_desc2", "2021-11-26", 20, 45, 2);
        CreateTest("t_name3", "t_desc3", "2021-11-27", 30, 60, 3);
        CreateTest("t_name4", "t_desc4", "2021-11-28", 40, 75, 4);
        CreateHomework("h_name1", "h_desc1", "2021-12-25", 10, 1);
        CreateHomework("h_name2", "h_desc2", "2021-12-26", 20, 2);
        CreateHomework("h_name3", "h_desc3", "2021-12-27", 30, 3);
        CreateHomework("h_name4", "h_desc4", "2021-12-28", 40, 4);
        
        $expected = '[{"announcementid":1, "name":"a_name1", "description":"a_desc1", "duedate":"2021-10-25", "classroomid":1},' .
            '{"announcementid":2, "name":"a_name2", "description":"a_desc2", "duedate":"2021-10-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"a_name3", "description":"a_desc3", "duedate":"2021-10-27", "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":1, "name":"t_name1", "description":"t_desc1", "duedate":"2021-11-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"t_name2", "description":"t_desc2", "duedate":"2021-11-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"t_name3", "description":"t_desc3", "duedate":"2021-11-27", "points":30, "timelimit":60, "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":1, "name":"h_name1", "description":"h_desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"h_name2", "description":"h_desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"h_name3", "description":"h_desc3", "duedate":"2021-12-27", "points":30, "classroomid":3}]';
        $actual = GetParentEventListForAllClassrooms("james", "homework");
        $this->assertEquals($expected, $actual);

        $expected = '[{"announcementid":4, "name":"a_name4", "description":"a_desc4", "duedate":"2021-10-28", "classroomid":4}]';
        $actual = GetParentEventListForAllClassrooms("Al", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":4, "name":"t_name4", "description":"t_desc4", "duedate":"2021-11-28", "points":40, "timelimit":75, "classroomid":4}]';
        $actual = GetParentEventListForAllClassrooms("Al", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":4, "name":"h_name4", "description":"h_desc4", "duedate":"2021-12-28", "points":40, "classroomid":4}]';
        $actual = GetParentEventListForAllClassrooms("Al", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEventListFromAllClassroomsReturnsMultipleEventsInSameClassroom(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        JoinClassroom("james", "a");
        JoinClassroom("james", "b");
        CreateAnnouncement("a_name1", "a_desc1", "2021-10-25", 1);
        CreateAnnouncement("a_name2", "a_desc2", "2021-10-26", 2);
        CreateAnnouncement("a_name3", "a_desc3", "2021-10-27", 1);
        CreateTest("t_name1", "t_desc1", "2021-11-25", 10, 30, 1);
        CreateTest("t_name2", "t_desc2", "2021-11-26", 20, 45, 2);
        CreateTest("t_name3", "t_desc3", "2021-11-27", 30, 60, 1);
        CreateHomework("h_name1", "h_desc1", "2021-12-25", 10, 1);
        CreateHomework("h_name2", "h_desc2", "2021-12-26", 20, 2);
        CreateHomework("h_name3", "h_desc3", "2021-12-27", 30, 1);
        
        $expected = '[{"announcementid":1, "name":"a_name1", "description":"a_desc1", "duedate":"2021-10-25", "classroomid":1},' .
            '{"announcementid":2, "name":"a_name2", "description":"a_desc2", "duedate":"2021-10-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"a_name3", "description":"a_desc3", "duedate":"2021-10-27", "classroomid":1}]';
        $actual = GetParentEventListForAllClassrooms("james", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":1, "name":"t_name1", "description":"t_desc1", "duedate":"2021-11-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"t_name2", "description":"t_desc2", "duedate":"2021-11-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"t_name3", "description":"t_desc3", "duedate":"2021-11-27", "points":30, "timelimit":60, "classroomid":1}]';
        $actual = GetParentEventListForAllClassrooms("james", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":1, "name":"h_name1", "description":"h_desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"h_name2", "description":"h_desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"h_name3", "description":"h_desc3", "duedate":"2021-12-27", "points":30, "classroomid":1}]';
        $actual = GetParentEventListForAllClassrooms("james", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEventListFromAllClassroomsWithInvalidEventType(): void
    {
        $expected = -1;
        $actual = GetParentEventListForAllClassrooms("tom", "event");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEventListWithInvalidEventType(): void
    {
        $expected = -1;
        $actual = GetEventList(1, "event");
        $this->assertEquals($expected, $actual);
    }
/*
    public function testGetAllParentsInAllClassesOfUser(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "parent");
        AddUser("Al", "Jordan", "parent");
        CreateClassroom("science", "tom", "a");
        JoinClassroom("james", "a");
        JoinClassroom("Al", "a");
        
        $expected = '[{"homeworkid":4, "name":"h_name4", "description":"h_desc4", "duedate":"2021-12-28", "points":40, "classroomid":4}]';
        $actual = GetEventListForAllClassrooms("Al", "homework");
        $this->assertEquals($expected, $actual);
    }
 */

    public function testGetTeacherHomeworkListWithOneElementFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateHomework("name2", "desc2", "2021-12-26", 20, 2);
        
        $expected = '[{"homeworkid":1, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "classroomid":2}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherHomeworkListWithMultipleElementsFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateHomework("name1", "desc1", "2021-12-25", 10, 1);
        CreateHomework("name2", "desc2", "2021-12-26", 20, 2);
        CreateHomework("name3", "desc3", "2021-12-27", 30, 3);
        
        $expected = '[{"homeworkid":1, "name":"name1", "description":"desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"name3", "description":"desc3", "duedate":"2021-12-27", "points":30, "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyTeacherHomeworkListFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        
        $expected = '[]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherTestListWithOneElementFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateTest("name2", "desc2", "2021-12-26", 20, 45, 2);
        
        $expected = '[{"testid":1, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "timelimit":45, "classroomid":2}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherTestListWithMultipleElementsFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateTest("name1", "desc1", "2021-12-25", 10, 30, 1);
        CreateTest("name2", "desc2", "2021-12-26", 20, 45, 2);
        CreateTest("name3", "desc3", "2021-12-27", 30, 60, 3);
        
        $expected = '[{"testid":1, "name":"name1", "description":"desc1", "duedate":"2021-12-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"name3", "description":"desc3", "duedate":"2021-12-27", "points":30, "timelimit":60, "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyTeacherTestListFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        
        $expected = '[]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "test");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherAnnouncementListWithOneElementFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateAnnouncement("name2", "desc2", "2021-12-26", 2);
        
        $expected = '[{"announcementid":1, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "classroomid":2}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "announcement");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherAnnouncementListWithMultipleElementsFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateAnnouncement("name1", "desc1", "2021-12-25", 1);
        CreateAnnouncement("name2", "desc2", "2021-12-26", 2);
        CreateAnnouncement("name3", "desc3", "2021-12-27", 3);
        
        $expected = '[{"announcementid":1, "name":"name1", "description":"desc1", "duedate":"2021-12-25", "classroomid":1},' .
            '{"announcementid":2, "name":"name2", "description":"desc2", "duedate":"2021-12-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"name3", "description":"desc3", "duedate":"2021-12-27", "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "announcement");
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmptyTeacherAnnouncementListFromAllClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        
        $expected = '[]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "announcement");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherEventListFromAllClassroomsReturnsCorrectEvents(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateAnnouncement("a_name1", "a_desc1", "2021-10-25", 1);
        CreateAnnouncement("a_name2", "a_desc2", "2021-10-26", 2);
        CreateAnnouncement("a_name3", "a_desc3", "2021-10-27", 3);
        CreateTest("t_name1", "t_desc1", "2021-11-25", 10, 30, 1);
        CreateTest("t_name2", "t_desc2", "2021-11-26", 20, 45, 2);
        CreateTest("t_name3", "t_desc3", "2021-11-27", 30, 60, 3);
        CreateHomework("h_name1", "h_desc1", "2021-12-25", 10, 1);
        CreateHomework("h_name2", "h_desc2", "2021-12-26", 20, 2);
        CreateHomework("h_name3", "h_desc3", "2021-12-27", 30, 3);
        
        $expected = '[{"announcementid":1, "name":"a_name1", "description":"a_desc1", "duedate":"2021-10-25", "classroomid":1},' .
            '{"announcementid":2, "name":"a_name2", "description":"a_desc2", "duedate":"2021-10-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"a_name3", "description":"a_desc3", "duedate":"2021-10-27", "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":1, "name":"t_name1", "description":"t_desc1", "duedate":"2021-11-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"t_name2", "description":"t_desc2", "duedate":"2021-11-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"t_name3", "description":"t_desc3", "duedate":"2021-11-27", "points":30, "timelimit":60, "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":1, "name":"h_name1", "description":"h_desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"h_name2", "description":"h_desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"h_name3", "description":"h_desc3", "duedate":"2021-12-27", "points":30, "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherEventListFromAllClassroomsDoesNotReturnEventsInOtherClassrooms(): void
    {
        AddUser("tom", "stone", "teacher");
        AddUser("james", "smith", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateClassroom("math", "tom", "c");
        CreateClassroom("english", "james", "d");
        CreateAnnouncement("a_name1", "a_desc1", "2021-10-25", 1);
        CreateAnnouncement("a_name2", "a_desc2", "2021-10-26", 2);
        CreateAnnouncement("a_name3", "a_desc3", "2021-10-27", 3);
        CreateAnnouncement("a_name4", "a_desc4", "2021-10-28", 4);
        CreateTest("t_name1", "t_desc1", "2021-11-25", 10, 30, 1);
        CreateTest("t_name2", "t_desc2", "2021-11-26", 20, 45, 2);
        CreateTest("t_name3", "t_desc3", "2021-11-27", 30, 60, 3);
        CreateTest("t_name4", "t_desc4", "2021-11-28", 40, 75, 4);
        CreateHomework("h_name1", "h_desc1", "2021-12-25", 10, 1);
        CreateHomework("h_name2", "h_desc2", "2021-12-26", 20, 2);
        CreateHomework("h_name3", "h_desc3", "2021-12-27", 30, 3);
        CreateHomework("h_name4", "h_desc4", "2021-12-28", 40, 4);
        
        $expected = '[{"announcementid":1, "name":"a_name1", "description":"a_desc1", "duedate":"2021-10-25", "classroomid":1},' .
            '{"announcementid":2, "name":"a_name2", "description":"a_desc2", "duedate":"2021-10-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"a_name3", "description":"a_desc3", "duedate":"2021-10-27", "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":1, "name":"t_name1", "description":"t_desc1", "duedate":"2021-11-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"t_name2", "description":"t_desc2", "duedate":"2021-11-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"t_name3", "description":"t_desc3", "duedate":"2021-11-27", "points":30, "timelimit":60, "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":1, "name":"h_name1", "description":"h_desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"h_name2", "description":"h_desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"h_name3", "description":"h_desc3", "duedate":"2021-12-27", "points":30, "classroomid":3}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "homework");
        $this->assertEquals($expected, $actual);

        $expected = '[{"announcementid":4, "name":"a_name4", "description":"a_desc4", "duedate":"2021-10-28", "classroomid":4}]';
        $actual = GetTeacherEventListForAllClassrooms("james", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":4, "name":"t_name4", "description":"t_desc4", "duedate":"2021-11-28", "points":40, "timelimit":75, "classroomid":4}]';
        $actual = GetTeacherEventListForAllClassrooms("james", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":4, "name":"h_name4", "description":"h_desc4", "duedate":"2021-12-28", "points":40, "classroomid":4}]';
        $actual = GetTeacherEventListForAllClassrooms("james", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherEventListFromAllClassroomsReturnsMultipleEventsInSameClassroom(): void
    {
        AddUser("tom", "stone", "teacher");
        CreateClassroom("science", "tom", "a");
        CreateClassroom("history", "tom", "b");
        CreateAnnouncement("a_name1", "a_desc1", "2021-10-25", 1);
        CreateAnnouncement("a_name2", "a_desc2", "2021-10-26", 2);
        CreateAnnouncement("a_name3", "a_desc3", "2021-10-27", 1);
        CreateTest("t_name1", "t_desc1", "2021-11-25", 10, 30, 1);
        CreateTest("t_name2", "t_desc2", "2021-11-26", 20, 45, 2);
        CreateTest("t_name3", "t_desc3", "2021-11-27", 30, 60, 1);
        CreateHomework("h_name1", "h_desc1", "2021-12-25", 10, 1);
        CreateHomework("h_name2", "h_desc2", "2021-12-26", 20, 2);
        CreateHomework("h_name3", "h_desc3", "2021-12-27", 30, 1);
        
        $expected = '[{"announcementid":1, "name":"a_name1", "description":"a_desc1", "duedate":"2021-10-25", "classroomid":1},' .
            '{"announcementid":2, "name":"a_name2", "description":"a_desc2", "duedate":"2021-10-26", "classroomid":2},' . 
            '{"announcementid":3, "name":"a_name3", "description":"a_desc3", "duedate":"2021-10-27", "classroomid":1}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "announcement");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"testid":1, "name":"t_name1", "description":"t_desc1", "duedate":"2021-11-25", "points":10, "timelimit":30, "classroomid":1},' .
            '{"testid":2, "name":"t_name2", "description":"t_desc2", "duedate":"2021-11-26", "points":20, "timelimit":45, "classroomid":2},' . 
            '{"testid":3, "name":"t_name3", "description":"t_desc3", "duedate":"2021-11-27", "points":30, "timelimit":60, "classroomid":1}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "test");
        $this->assertEquals($expected, $actual);
        
        $expected = '[{"homeworkid":1, "name":"h_name1", "description":"h_desc1", "duedate":"2021-12-25", "points":10, "classroomid":1},' .
            '{"homeworkid":2, "name":"h_name2", "description":"h_desc2", "duedate":"2021-12-26", "points":20, "classroomid":2},' . 
            '{"homeworkid":3, "name":"h_name3", "description":"h_desc3", "duedate":"2021-12-27", "points":30, "classroomid":1}]';
        $actual = GetTeacherEventListForAllClassrooms("tom", "homework");
        $this->assertEquals($expected, $actual);
    }

    public function testGetTeacherEventListFromAllClassroomsWithInvalidEventType(): void
    {
        $expected = -1;
        $actual = GetTeacherEventListForAllClassrooms("tom", "event");
        $this->assertEquals($expected, $actual);
    }

}
?>

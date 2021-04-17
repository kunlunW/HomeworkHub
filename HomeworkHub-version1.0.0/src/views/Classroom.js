import React from "react";
import axios from "axios";
import { 
  Card,
  Container,
  Row,
  Col
} from "react-bootstrap";

import default_img from "../Picture/generic_classroom.jpg"

const mock_parents = [
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"}
];

export class Classroom extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: localStorage.getItem("username"),
      classroomName: localStorage.getItem("classroomName"),
      classroomId: localStorage.getItem("classroomId"),
      parents: [], //parents enrolled in this class
      homeworks: [], //homework assignments for this class
      announcements: [], //announcements for this class
      tests: [] //tests for this class
    };

    this.getParents = this.getParents.bind(this);
    this.getHomeworks = this.getHomeworks.bind(this);
    this.getAnnouncements = this.getAnnouncements.bind(this);
    this.getTests = this.getTests.bind(this);

    this.getEventsHomework();
    this.getEventsTest();
    this.getEventsAnnouncement();
  }

  getEventsHomework() { 
    const url = "/HomeworkHub/backend/get_event_list.php";
    let formData = new FormData();
    let data = '{"classroomid":"' + this.state.classroomId + '", "type":"homework"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
        //  console.log(res);
         this.setState({homeworks: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
  }

  getEventsTest() { 
    const url = "/HomeworkHub/backend/get_event_list.php";
    let formData = new FormData();
    let data = '{"classroomid":"' + this.state.classroomId + '", "type":"test"}';
    formData.append("formData", data);
    console.log(data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
        //  console.log(res);
         this.setState({tests: [...res]});
     })
     .catch(err=>console.log(err));
  }

  getEventsAnnouncement() {
    const url = "/HomeworkHub/backend/get_event_list.php";
    let formData = new FormData();
    let data = '{"classroomid":"' + this.state.classroomId + '", "type":"announcements"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
        //  console.log(res);
         this.setState({announcements: [...res]});
     })
     .catch(err=>console.log(err));
  }

  loadParents() {
    const url = "/HomeworkHub/backend/get_all_parents_in_classroom.php";
    let formData = new FormData();
    let data = '{"classroomid":"' + this.state.classroomId + '"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
        //  console.log(res);
         this.setState({parents: [...res]});
     })
     .catch(err=>console.log(err));
  }

  getParents() {
    return this.state.parents.map(this.getParent);
  }

  getParent(parent) {
    return (
    <div>
        <Row>
            <Col>
                {parent.name}
            </Col>
            <Col>
                {parent.email}
            </Col>
            <Col>
                {parent.mobile_no}
            </Col>
            <Col>
                {parent.school}
            </Col>
        </Row>
    </div>
    );
  }

  getHomeworks() {
    return this.state.homeworks.map(this.getHomework);
  }

  getHomework(homework) {
    return (
    <div>
        <Row>
            <Col>
                {homework.name}
            </Col>
            <Col>
                {homework.description}
            </Col>
            <Col>
                {homework.duedate}
            </Col>
            <Col>
                {homework.points}
            </Col>
        </Row>
    </div>
    );
  }

  getAnnouncements() {
    return this.state.announcements.map(this.getAnnouncement);
  }

  getAnnouncement(announcement) {
    return (
    <div>
        <Row>
            <Col>
                {announcement.name}
            </Col>
            <Col>
                {announcement.description}
            </Col>
            <Col>
                {announcement.duedate}
            </Col>
        </Row>
    </div>
    );
  }

  getTests() {
    return this.state.tests.map(this.getTest);
  }

  getTest(test) {
    return (
    <div>
        <Row>
            <Col>
                {test.name}
            </Col>
            <Col>
                {test.description}
            </Col>
            <Col>
                {test.duedate}
            </Col>
            <Col>
                {test.points}
            </Col>
            <Col>
                {test.timelimit}
            </Col>
        </Row>
    </div>
    );
  }

  render() {
    return (
        <>
          <Container fluid>
            <Row>
                <h1>{this.state.classroomName}</h1>
            </Row>
            <Row>
                <h5>{"ClassroomID: " + this.state.classroomId}</h5>
                <br/><br/>
            </Row>
            <Row>
                <Col>
                <Card>
                    <Card.Header>
                        <Card.Title>
                            Parents
                        </Card.Title>
                    </Card.Header>
                    <Card.Body>
                        <Row>
                            <Col>
                                <h6>Name</h6>
                            </Col>
                            <Col>
                                <h6>Email</h6>
                            </Col>
                            <Col>
                                <h6>Mobile No</h6>
                            </Col>
                            <Col>
                                <h6>School</h6>
                            </Col>
                        </Row>
                        <br/>
                        {this.getParents()}
                     </Card.Body>
    
                    </Card>
                </Col>
                <Col>
                    <Card>
                        <Card.Header>
                            <Card.Title>
                                Announcements
                            </Card.Title>
                        </Card.Header>
                        <Card.Body>
                            <Row>
                                <Col>
                                    <h6>Name</h6>
                                </Col>
                                <Col>
                                    <h6>Description</h6>
                                </Col>
                                <Col>
                                    <h6>Date</h6>
                                </Col>
                            </Row>
                            <br/>
                            {this.getAnnouncements()}
                        </Card.Body>
    
                    </Card>
                </Col>
            </Row>

            <Row>
                <Col>
                    <Card>
                        <Card.Header>
                        <Card.Title>
                            Homework
                        </Card.Title>
                        </Card.Header>
                        <Card.Body>
                            <Row>
                                <Col>
                                    <h6>Name</h6>
                                </Col>
                                <Col>
                                    <h6>Description</h6>
                                </Col>
                                <Col>
                                    <h6>Due date</h6>
                                </Col>
                                <Col>
                                    <h6>Points</h6>
                                </Col>
                            </Row>
                            <br/>
                            {this.getHomeworks()}
                        </Card.Body>
    
                    </Card>
                </Col>
                <Col>
                    <Card>
                        <Card.Header>
                            <Card.Title>
                            Test Dates
                            </Card.Title>
                        </Card.Header>
                        <Card.Body>
                            <Row>
                                <Col>
                                    <h6>Name</h6>
                                </Col>
                                <Col>
                                    <h6>Description</h6>
                                </Col>
                                <Col>
                                    <h6>Date</h6>
                                </Col>
                                <Col>
                                    <h6>Points</h6>
                                </Col>
                                <Col>
                                    <h6>Time Limit</h6>
                                </Col>
                            </Row>
                            <br/>
                            {this.getTests()}
                        </Card.Body>
    
                    </Card>
                </Col>
            </Row>
          </Container>
        </>
      );
  }
}

export default Classroom;
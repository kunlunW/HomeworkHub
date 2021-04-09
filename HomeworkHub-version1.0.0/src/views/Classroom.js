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
const mock_homeworks = [
    {name: "Science Ch1", due: "2021-03-06"},
    {name: "Science Ch2", due: "2021-05-06"},
    {name: "Science Ch1", due: "2021-03-06"},
    {name: "Science Ch1", due: "2021-03-06"},
    {name: "Science Ch1", due: "2021-03-06"}
];
const mock_announcements = [
    {name: "Homework #3 cancelled", desc: "You do not have to complete the assigned homework #3."},
    {name: "Test tomorrow", desc: "A reminder that there is a test tomorrow."},
    {name: "No school tomorrow", desc: "Just a reminder that there is no school tomorrow."},

];
const mock_tests = [
    {name: "Science test", date: "2021-03-03"},
    {name: "Test #2", date: "2021-04-04"}
];

export class Classroom extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: localStorage.getItem("username"),
      classroomName: localStorage.getItem("classroomName"),
      classroomId: localStorage.getItem("classroomId"),
      parents: [...mock_parents], //parents enrolled in this class
      homeworks: [...mock_homeworks], //homework assignments for this class
      announcements: [...mock_announcements], //announcements for this class
      tests: [...mock_tests] //tests for this class
    };
    this.getParents = this.getParents.bind(this);
    this.getHomeworks = this.getHomeworks.bind(this);
    this.getAnnouncements = this.getAnnouncements.bind(this);
    this.getTests = this.getTests.bind(this);

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
                {parent.phone}
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
                {homework.due}
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
                {announcement.desc}
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
                {test.date}
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
                <br/><br/>
            </Row>
            <Row>
                <Col>
                <Card>
                    <Card.Header>
                        <Card.Title>
                            Tests
                        </Card.Title>
                    </Card.Header>
                    <Card.Body>
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
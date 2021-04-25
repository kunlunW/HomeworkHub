import React from "react";
import axios from "axios";
import  { Redirect } from 'react-router-dom';
import { 
  Card,
  Container,
  Row,
  Col
} from "react-bootstrap";

export class ParentClassroom extends React.Component {
  constructor(props) {
    super(props);
    var classroom = localStorage.getItem("parentclassroomId");
    var tojoin = null;
    if (classroom == 0) {
        tojoin = "/parent/join";
    }
    this.state = {
      username: localStorage.getItem("parentusername"),
      classroomId: localStorage.getItem("parentclassroomId"),
      parents: [], //parents enrolled in this class
      homeworks: [], //homework assignments for this class
      announcements: [], //announcements for this class
      tests: [], //tests for this class
      join: tojoin
    };

    this.getEventHomeworks = this.getEventHomeworks.bind(this);
    this.getEventAnnouncements = this.getEventAnnouncements.bind(this);
    this.getEventTests = this.getEventTests.bind(this);

    if (this.state.classroomId != 0) {
        this.getEventHomeworks();
        this.getEventAnnouncements();
        this.getEventTests();
    }
  }

  getEventHomeworks() { 
    const url = "/HomeworkHub/backend/get_event_list.php";
    let formData = new FormData();
    let data = '{"classroomid":"' + this.state.classroomId + '", "type":"homework"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         this.setState({homeworks: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
  }

  getEventTests() { 
    const url = "/HomeworkHub/backend/get_event_list.php";
    let formData = new FormData();
    let data = '{"classroomid":"' + this.state.classroomId + '", "type":"test"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         this.setState({tests: [...res]});
     })
     .catch(err=>console.log(err));
  }

  getEventAnnouncements() {
    const url = "/HomeworkHub/backend/get_event_list.php";
    let formData = new FormData();
    let data = '{"classroomid":"' + this.state.classroomId + '", "type":"announcement"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         this.setState({announcements: [...res]});
     })
     .catch(err=>console.log(err));
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
    if (this.state.join) {
        return (<Redirect to={this.state.join} />)
    } 
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
                <Card style={{width:"90%", margin: "0 auto", float: "none", "margin-bottom": "40px"}}>
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
            </Row>

            <Row>
                <Card style={{width:"90%", margin: "0 auto", float: "none", "margin-bottom": "40px"}}>
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

            </Row>

            <Row>
                <Card style={{width:"90%", margin: "0 auto", float: "none", "margin-bottom": "40px"}}>
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
            </Row>
          </Container>
        </>
      );
  }
}

export default ParentClassroom;
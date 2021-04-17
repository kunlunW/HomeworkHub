import React, {useState, Link} from "react";
import  { Redirect } from 'react-router-dom';
import axios from "axios";
import { 
  Card,
  Container,
  Row,
  Col,
  FormGroup,
  FormControl,
  Button,
  FormLabel,
} from "react-bootstrap";

import default_img from "../Picture/generic_classroom.jpg"

const mock_classrooms = [
  {name: "English", teacher: "Mr.Badger"},
  {name: "Science", teacher: "Mr.Badger"},
  {name: "Math", teacher: "Mr.Badger"},
  {name: "Social Studies", teacher: "Mr.Badger"}
];

export class viewClass extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: localStorage.getItem("username"),
      classrooms: [],
      new_classroom_name: "",
      success: false,
      chosen: null
    };
    this.create_new_classroom = this.create_new_classroom.bind(this);
    this.get_classrooms = this.get_classrooms.bind(this);
    this.create_card = this.create_card.bind(this);
    this.delete_classroom = this.delete_classroom.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.get_classrooms();
  }
  
  
  //Retrieves each classroom for current user, called when creating cards
  get_classrooms() {
    const url = "/HomeworkHub/backend/get_teacher_classrooms.php";
    let formData = new FormData();
    let data = '{"username":"' + localStorage.getItem("username") + '"}';
    formData.append('formData', data);
    axios.post(url, formData)
    .then(response => {
        var res = response["data"];
        this.setState({classrooms: [...res]});
    })
    .catch(err=>console.log(err));
  }

  //Creates a new classroom in the db
  create_new_classroom() {
    const url = "/HomeworkHub/backend/create_classroom.php";
    let formData = new FormData();
    let data = '{"classroomname":"' + this.state.new_classroom_name + '", "teachername":"' + this.state.username + '"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         if (res > 0) {
           this.setState({success: true});
           this.get_classrooms();
         }
     })
     .catch(err=>console.log(err));
  }

  delete_classroom(classroom_name) {
    this.setState({success: false});
    const url = "/HomeworkHub/backend/deleteClassroom.php";
    let formData = new FormData();
    let data = '{"classroomname":"' + classroom_name +'"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        console.log(res);
        this.get_classrooms();
     })
     .catch(err=>console.log(err));
  }

  create_cards() {
    return this.state.classrooms.map(this.create_card);
   }

  create_card(classroom) {
    return (
    <div>
      <Card>
        <img class="card-img-top" src={default_img}  />
        <Card.Body>
          <Row>
            <Col>
              <Row>
                <a href = "/admin/classroom" onClick={() => this.setState({chosen: classroom})}> {classroom.classroomname}</a>
              </Row>
            </Col>
            <Col>
              <div class="text-right">
                <button className="btn btn-xs rounded">Edit</button>
                <button className="btn btn-danger btn-xs rounded" onClick={()=>{this.delete_classroom(classroom.classroomname)}}>Delete</button>
              </div>
            </Col>
         </Row>
        </Card.Body>
        <Card.Footer>
        <Row>
          <h6>{"ClassroomId: " + classroom.classroomid}</h6>
        </Row>
        </Card.Footer>
      </Card>
    </div>
    );
  }

  handleChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };

  render() {
    if (this.state.chosen) {
      localStorage.setItem("classroomName", this.state.chosen.classroomname);
      localStorage.setItem("classroomId", this.state.chosen.classroomid);
      return <Redirect to={"/admin/classroom"} />
    }

    return (
    <Container fluid>
      <Row>
        <h3>{"My Classrooms"}</h3>
      </Row>
      <br/>
      <Row>
        <Col>
          {this.create_cards(this.state.classrooms)}
        </Col>
        <Col>
          <FormGroup controlId = "create" size = "lg">
            <FormLabel>Create new classroom</FormLabel>
            <FormControl
                value={this.state.new_classroom_name}
                onChange={this.handleChange}
                placeholder="Enter name"
                name = "new_classroom_name"
            />
          </FormGroup>
          <Button onClick={this.create_new_classroom}>Create</Button>
          { this.state.success ? <h6>Success</h6> : null}
        </Col>
      </Row>
    </Container>
    );
  }
}

export default viewClass;

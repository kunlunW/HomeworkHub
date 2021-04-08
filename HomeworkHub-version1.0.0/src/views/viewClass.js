import React, {useState, Link} from "react";
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
      classrooms: [this.get_classrooms()],
      new_classroom_name: "",
      success: false
    };
    this.create_new_classroom = this.create_new_classroom.bind(this);
    this.handleChange = this.handleChange.bind(this);
  }
  
  
  //Retrieves each classroom for current user, called when creating cards
  get_classrooms() {

    const url = "/HomeworkHub/backend/get_teacher_classrooms.php";
    let formData = new FormData();
    let data = '{"username":"' + /*this.state.username*/localStorage.getItem("username") + '"}';
    formData.append('formData', data);
    axios.post(url, formData)
    .then(response => {
        var res = response["data"];
        this.setState({classrooms: [...res]});
        console.log(this.state.classrooms);
    })
    .catch(err=>console.log(err));


    return [];
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
          {classroom.classroomname}
        </Card.Body>
        <Card.Footer>
          {classroom.teachername}
        </Card.Footer>
      </Card>
    </div>
    );
  }

  //Creates a new classroom in the db
  create_new_classroom() {
    console.log(this.state.new_classroom_name);
    
    const url = "/HomeworkHub/backend/create_classroom.php";
    let formData = new FormData();
    let data = '{"classroomname":"' + this.state.new_classroom_name + '", "teachername":"' + this.state.username + '"}';
    formData.append("formData", data);
    axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         console.log(res);
         if (res > 0) {
           this.setState({success: true});
           this.get_classrooms();
         }
     })
     .catch(err=>console.log(err));
  }

  handleChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };

  render() {
    return (
    <Container fluid>
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

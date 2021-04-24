import React  from "react";
import axios from "axios";
import  { Redirect } from 'react-router-dom';
import { 
  FormGroup,
  FormControl,
  Card,
  Container,
  Row,
  Col,
  Button
} from "react-bootstrap";

import default_img from "../Picture/generic_classroom.jpg"

const mock_parents = [
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"},
    {name: "Chester Tester", email: "test@123.com", phone: "(123) 456-7890"}
];

export class ParentJoinClass extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: localStorage.getItem("parentusername"),
      joincode: "",
      redirect: null
    };
    this.joinClassroom = this.joinClassroom.bind(this);
    this.getClassroomId = this.getClassroomId.bind(this);
    this.handleChange = this.handleChange.bind(this);
  }

  getClassroomId() {
    const url = "/HomeworkHub/backend/get_parent_cid.php";
    let formData = new FormData();
    let data = '{"username":"' + this.state.username + '"}';
    formData.append("formData", data);
    axios.post(url, formData)
    .then(response => {
        var res = response["data"];
       // console.log(res);
        localStorage.setItem("parentclassroomId", res);
    })
    .catch(err=>console.log(err.response, err.request));
  }

  joinClassroom() {
    const url = "/HomeworkHub/backend/join_classroom.php";
    let formData = new FormData();
    let data = '{"username":"' + this.state.username + '", "joincode":"' + this.state.joincode + '"}';
    formData.append("formData", data);
    console.log(data);
    axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        if (res === 0) {
            this.getClassroomId();
            this.setState({redirect: "/parent/dashboard"});
        }
         
     })
     .catch(err=>console.log(err.response, err.request));
  }

  handleChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };

  render() {
    if (this.state.redirect) {
        return <Redirect to={this.state.redirect} />
    }
    
    return (
        <>
          <Container fluid>
            <div>
                <h3>You have not joined a classroom yet...</h3>
            </div>
            <FormGroup controlId = "code" size = "lg">
            <FormControl
                value={this.state.joincode}
                onChange={this.handleChange}
                placeholder="Enter a join code"
                name = "joincode"
            />
          </FormGroup>
            <Button onClick={this.joinClassroom}>Join Classroom</Button>
          </Container>
        </>
      );
  }
}

export default ParentJoinClass;
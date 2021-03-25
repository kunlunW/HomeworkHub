import React, { Component } from "react";
import  { Redirect } from 'react-router-dom'
import axios from "axios";
import { Button,
         FormGroup,
         FormControl,
         } from "react-bootstrap";



export default class LogIn extends Component {
  constructor(props) {
    super(props);
    this.state = {
      username: "",
      password: "",
      wrongPass: false,
    };

    this.handleChange = this.handleChange.bind(this);
  }

  handleLoginButtonClick = () => {
    const url = "/HomeworkHub/backend/login.php";
    let formData = new FormData();
    let data = '{"username":"' + this.state.username + '", "password":"' + this.state.password + '"}';
    formData.append("formData", data);
    axios.post(url, formData)
    .then(response => {
        // console.log(response);
        // console.log(response["data"]);
        var res = response["data"];
        if (res == 0) {
          console.log("user found");
        } else {
          console.log("user not found")
        }
    })
    .catch(err=>console.log(err));
  }

  handleChange = event => {
    this.setState({
      [event.target.id]: event.target.value,
    });
  };

  render() {
 
    return ( 
      <div className="loginpage">
        <h1>Log In</h1>
        <br/> 
          <FormGroup controlId="username" size="lg">
           
            <FormControl
              autoFocus
              placeholder="Enter Username"
              value={this.state.username}
              onChange={this.handleChange}
              type="username"
            />
          </FormGroup>

          <FormGroup controlId="password" size="lg">
            <FormControl
              placeholder="Enter Password"
              value={this.state.password}
              onChange={this.handleChange}
              type="password"
            />
          </FormGroup>

          <h5>Don't have an account? <a href="/signup" > Register Now</a></h5>

          <button
            block
            size="lg"
            onClick = {this.handleLoginButtonClick}>Login
          </button>
      </div>
    );
  }
}
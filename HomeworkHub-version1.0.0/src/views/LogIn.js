import React, { Component } from "react";
import  { Redirect } from 'react-router-dom';
import axios from "axios";
import { FormGroup,
         FormControl,
         } from "react-bootstrap";



export default class LogIn extends Component {
  constructor(props) {
    super(props);
    this.state = {
      username: "",
      password: "",
      redirect: null,
      wrongPass: false,
      empty: false,
    };
    this.handleChange = this.handleChange.bind(this);
  }

  handleLoginButtonClick = () => {
    if (this.state.username === "" || this.state.password === "") {
      this.setState({empty: true});
      return;
  } else {
      this.setState({empty: false}); 
  }
    const url = "/HomeworkHub/backend/login.php";
    let formData = new FormData();
    let data = '{"username":"' + this.state.username + '", "password":"' + this.state.password + '"}';
    formData.append("formData", data);
    axios.post(url, formData)
    .then(response => {
        var res = response["data"];
        //Need to add else if ("parent") when implementing parent side
        if (res == "teacher") {
          console.log("teacher user found");
          this.setState({
            redirect: "/admin/dashboard",
          });
        } else {
          this.setState({
            wrongPass: true,
          });
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
    if (this.state.redirect) {
      return <Redirect to={this.state.redirect} />
    }
 
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

          { this.state.wrongPass ? <h6>Username or password incorrect</h6> : null }
          { this.state.empty ? <h6>Please enter a username and password</h6> : null }

          <h5>Don't have an account? <a href="/welcome/signup" > Register Now</a></h5>

          <h5> Temporary <a href="/admin/dashboard" > Redirect </a></h5>



          <button
            block
            size="lg"
            onClick = {this.handleLoginButtonClick}>
              Login
          </button>
      </div>
    );
  }
}
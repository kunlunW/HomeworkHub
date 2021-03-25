import React, { Component } from "react";
import  { Redirect } from 'react-router-dom';
import axios from "axios";
import { FormGroup,
         FormControl,
         } from "react-bootstrap";



export default class Signup extends Component {
  constructor() {
    super();
    this.state = {
      isLoading: false,
      username: "",
      password: "",
      confirmPassword: "",
      type: null,
      redirect: null,
      passMatch: true,
      badUsername: false,
      selected: true,
      regError: false,
      empty: false
    }
    this.handleChange = this.handleChange.bind(this);
  }

  handleChange = event => {
    this.setState({
      [event.target.id]: event.target.value
    });
  }

  handleTypeChange = () => {
    var parent = document.getElementById("Parent");
    var teacher = document.getElementById("Teacher");
    if (teacher.checked) {
        this.setState({type: "teacher"});
    } else if (parent.checked) {
        this.setState({type: "parent"});
    }
    this.setState({selected: true});
  }

  handleRegisterButtonClick = () => {
    this.setState({badUsername: false, regError: false});
    if (this.state.username === "" || this.state.password === "") {
        this.setState({empty: true});
        return;
    } else {
        this.setState({empty: false}); 
    }
    if (this.state.password !== this.state.confirmPassword) {
        this.setState({passMatch: false, });
        return;
    } else {
        this.setState({passMatch:true});
    }

    if (this.state.type === null) {
        this.setState({selected: false});
        return;
    } else {
        this.setState({selected: true});
    }

    const url = "/HomeworkHub/backend/register.php";
    let formData = new FormData();
    let data = '{"username":"' + this.state.username + '", "password":"' + this.state.password + '", "type":"' + this.state.type + '"}';
    formData.append("formData", data);
    axios.post(url, formData)
    .then(response => {
        var res = response["data"];
        if (res == 0) {

            this.setState({redirect: "/login"});
            
        } else if (res == 1) {
            this.setState({regError: true})
        } else if (res == 2) {
            this.setState({badUsername: true});
        }
    })
    .catch(err=>console.log(err));
  }

  render() {
      if (this.state.redirect) {
        return <Redirect to={this.state.redirect} />
      }

      return (
        <div className="signuppage">
          <h1>Sign Up </h1>
          <br/>
          
          <FormGroup controlId = "username" size = "lg">
            <FormControl
                value={this.state.username}
                onChange={this.handleChange}
                placeholder="Enter username"
            />
          </FormGroup>

          <FormGroup controlId="password" size = "lg">
             <FormControl
                value={this.state.password}
                onChange={this.handleChange}
                type="password"
                placeholder="Enter Password"
              />
          </FormGroup>

          <FormGroup controlId="confirmPassword" size = "lg">
            <FormControl
                value={this.state.confirmPassword}
                onChange={this.handleChange}
                type="password"
                placeholder="Enter Password"
            />
          </FormGroup>
          <input type="radio" id = "Teacher" name = "type" value = "teacher" onClick = {this.handleTypeChange} /> Teacher 
          <br/>   
          <input type="radio" id = "Parent" name = "type" value = "parent" onClick = {this.handleTypeChange}/> Parent
          <div>
          { this.state.selected ? <br/> : <h6>Please select account type</h6> }
          { this.state.passMatch ? null : <h6>Passwords do not match</h6> }
          { this.state.badUsername ? <h6>Username already in use</h6> : null }
          { this.state.regError ? <h6>There was an error during registration</h6> : null }
          { this.state.empty ? <h6>Please enter a username and password</h6> : null }
          </div>
          <br/>
          <h5>Already a user? <a href="/login" > Log in</a></h5>
          <button block size="lg" onClick = {this.handleRegisterButtonClick} > 
              Register
          </button>
        </div>
      );
    }
  }
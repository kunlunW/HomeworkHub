import React from "react";
import {
  Container,
  Row,
  Col,
  Card,
  Form, 
  Button,
  Carousel
} from "react-bootstrap";
import Table from "./Table";
import Table2 from "./Table2";

// import img from "../Picture/art.jpg";



function AddHW() {
  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
          <div>

          <h3>HW Card View</h3>
  <div class="card-header">

    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="#">Description</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Edit</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Ask for help!</a>
      </li>
    </ul>
  </div>
  
    {/* <img class="card-img" src={img} style={{width: 300, height: 'auto', opacity:0.4}} alt="Card image cap"/> */}

  <div class="card-body">

    <h3 class="card-title">Introductory art <span class="badge badge-secondary">New</span> </h3>
    
    <p class="card-text">Add some HW description.</p>
    <p class="card-text">Add some instruction link here.</p>
    <a href="#" class="btn btn-primary">Finish Now!</a>
  </div>
  <div class="card-footer text-muted">
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Due Date Coming Up:</strong> In 2 days
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
  </div>



  <br/> 

  <h3>HW Table View</h3>
  <Table />

  <br/> 
  <Table2 />
  

  {/* <div class="card bg-dark text-white">
  <img class="card-img" src={img} alt="Card image"/>
  <div class="card-img-overlay">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
    <p class="card-text">Last updated 3 mins ago</p>
  </div>
</div> */}


</div>



          </Col>
        </Row>
      </Container>
    </>
  );
}
export default AddHW;

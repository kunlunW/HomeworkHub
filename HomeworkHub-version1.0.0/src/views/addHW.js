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

function AddHW() {
  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
          <div>
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
  <br/>
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
</div>
          </Col>
        </Row>
      </Container>
    </>
  );
}
export default AddHW;

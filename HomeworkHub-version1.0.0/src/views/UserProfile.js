import React, { useState } from 'react';import {
  Container,
  Row,
  Col,
  Card,
  Form, 
  Button,
  Carousel
} from "react-bootstrap";
import FormikForm from './FormikForm';


function User() {

  const [fields, updateFields] = useState(
    {
      name: 'TestUser_1',
      email: 'test@example.com',
      mobile_no: '012345678',
      school: "Badger Primary School"
    }
  );
  return (
    <>
      <Container fluid>
        <Row>
          <Col md="10">
            
            <Card>
              <Card.Header>
                <Card.Title as="h3">Edit Profile</Card.Title>
              </Card.Header>

              <Card.Body>
                <Form>
                  <Row> 


                  <Col md="3">
                      <Form.Group>
                        <label>Username</label>
                        <Form.Control
                          defaultValue="Badger123"
                          type="text"

                        ></Form.Control>
                      </Form.Group>
                    </Col>


                    <Col md="3">
                      <Form.Group>
                        <label>Password</label>
                        <Form.Control
                          defaultValue="testingpassword"
                          type="text"
                        ></Form.Control>
                      </Form.Group>
                    </Col>
                  </Row>

                  <Row> 
                    <Col md="5"> 
                    <Form.Group>
                        <label> School </label>
                        <Form.Control
                          defaultValue="Badger Primary School"
                          type="text"
                        ></Form.Control>
                      </Form.Group>
                    </Col>
                  </Row>

                  <Button
                    type="button" 
                    class="btn btn-primary"
                  >
                    Update Profile
                  </Button>
                </Form>

                <FormikForm fields={fields} updateFields={updateFields}/>


              </Card.Body>

            </Card>

          </Col>
        </Row>
      </Container>
    </>
  );
}
export default User;

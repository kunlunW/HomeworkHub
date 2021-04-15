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
      name: "",
      gender: "male",
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
              

              <Card.Body>
                

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

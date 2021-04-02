import React from "react";
import cellEditFactory from 'react-bootstrap-table2-editor';
import BootstrapTable from 'react-bootstrap-table-next';
import {
  Container,
  Row,
  Col,
} from "react-bootstrap";

const columns = [{
  dataField: 'id',
  text: 'Product ID',
  sort: true
}, {
  dataField: 'name',
  text: 'Product Name',
  sort: true
}, {
  dataField: 'price',
  text: 'Product Price'
}];


function addTest() {
  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
          
          </Col>
        </Row>
      </Container>
    </>
  );
}
export default addTest;

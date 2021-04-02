import React from "react";

import {
  Badge,
  Button,
  Card,
  Navbar,
  Nav,
  Table,
  Container,
  Row,
  Col,
  Dropdown,
  Pagination
} from "react-bootstrap";


function viewStudent() {
  
  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
            <Card>
              <Card.Header>
                <Card.Title as="h4">Classroom 1</Card.Title>
                <p className="card-category">
                  Teacher: <a href="#" > Mr.Badger </a>
                </p>
              </Card.Header>
              <Card.Body >
                <Table className="table-hover table-striped">
                  <thead>
                    <tr>
                      <th className="border-0">Student ID</th>
                      <th className="border-0">Student Name</th>
                      <th className="border-0">Teacher</th>
                      <th className="border-0">Parents</th>
                      <th className="border-0">Grade</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><a href="#" > Student 1 </a></td>
                      
                      <td>Mr.Badger</td>
                      <td><a href="#" > Parent 1 </a></td>
                      <td>First</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td><a href="#" > Student 2 </a></td>
                      <td>Mr.Badger</td>
                      <td><a href="#" > Parent 2 </a></td>
                      <td>First</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td><a href="#" > Student 3 </a></td>
                      <td>Mr.Badger</td>
                      <td><a href="#" > Parent 3 </a></td>
                      <td>First</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td><a href="#" > Student 4 </a></td>
                      <td>Mr.Badger</td>
                      <td><a href="#" > Parent 4 </a></td>
                      <td>First</td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td><a href="#" > Student 5 </a></td>
                      <td>Mr.Badger</td>
                      <td><a href="#" > Parent 5 </a></td>
                      <td>First</td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td><a href="#" > Student 6 </a></td>
                      <td>Mr.Badger</td>
                      <td><a href="#" > Parent 6 </a></td>
                      <td>First</td>
                    </tr>
                  </tbody>
                </Table>
              </Card.Body>
            </Card>
          </Col>
          
        </Row>

        <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1">Previous</a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">4</a></li>
      <li class="page-item"><a class="page-link" href="#">...</a></li>
      <li class="page-item">
        <a class="page-link" href="#">Next</a>
      </li>
    </ul>
  </nav>
        
      </Container>
    </>
  );
}


export default viewStudent;

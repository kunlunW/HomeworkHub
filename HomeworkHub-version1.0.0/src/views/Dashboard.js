import React from "react";
import { 
  Card,
  Container,
  Row,
  Col,
  Carousel 
} from "react-bootstrap";

import img from "../Picture/UW.jpg";

function Dashboard() {
  return (
    <>
    
      <Container fluid>
      <Carousel>
            <Carousel.Item>
              <img width={1200} height={400}  src={img} />
              <Carousel.Caption>
              <h3>Welcome to Homework Hub</h3>
              <p>Build Bridge between teachers and parents</p>
              </Carousel.Caption>
            </Carousel.Item>
            <Carousel.Item>
              <img width={1200} height={400} src={img} />
              <Carousel.Caption>
              <h3>Welcome to Homework Hub</h3>
              <p>Build Bridge between teachers and parents</p>
              </Carousel.Caption>
            </Carousel.Item>
            <Carousel.Item>
              <img width={1200} height={400} src={img} />
              <Carousel.Caption>
              <h3>Welcome to Homework Hub</h3>
              <p>Build Bridge between teachers and parents</p>
              </Carousel.Caption>
            </Carousel.Item>
          </Carousel>
        
        <br/>
        <Row>
          <Col lg="3" sm="6">
            
          


            <Card className="card-stats">
              <Card.Body>
                <Row>
                  <Col xs="5">
                    <div className="icon-big text-center icon-warning">
                      <i className="nc-icon nc-circle-09 text-warning"></i>
                    </div>
                  </Col>
                  <Col xs="7">
                    <div className="numbers">
                      <p className="card-category">Student Count</p>
                      <Card.Title as="h4">200</Card.Title>
                    </div>
                  </Col>
                </Row>
              </Card.Body>
              <Card.Footer>
                <hr></hr>
                <div className="stats">
                  <i className="fas fa-search mr-2"></i>
                  View Detail
                </div>
              </Card.Footer>
            </Card>
          </Col>
          <Col lg="3" sm="6">
            <Card className="card-stats">
              <Card.Body>
                <Row>
                  <Col xs="5">
                    <div className="icon-big text-center icon-warning">
                      <i className="nc-icon nc-circle-09 text-warning"></i>
                    </div>
                  </Col>
                  <Col xs="7">
                    <div className="numbers">
                      <p className="card-category">Parent Count</p>
                      <Card.Title as="h4">200</Card.Title>
                    </div>
                  </Col>
                </Row>
              </Card.Body>
              <Card.Footer>
                <hr></hr>
                <div className="stats">
                <i className="fas fa-search mr-2"></i>
                  View Detail
                </div>
              </Card.Footer>
            </Card>
          </Col>
          <Col lg="3" sm="6">
            <Card className="card-stats">
              <Card.Body>
                <Row>
                  <Col xs="5">
                    <div className="icon-big text-center icon-warning">
                      <i className="nc-icon nc-bank text-danger"></i>
                    </div>
                  </Col>
                  <Col xs="7">
                    <div className="numbers">
                      <p className="card-category">Classroom</p>
                      <Card.Title as="h4">5</Card.Title>
                    </div>
                  </Col>
                </Row>
              </Card.Body>
              <Card.Footer>
                <hr></hr>
                <div className="stats">
                <i className="fas fa-search mr-2"></i>
                   View Detail
                </div>
              </Card.Footer>
            </Card>



            
          </Col>       
        </Row> 
      </Container>
    </>
  );
}

export default Dashboard;

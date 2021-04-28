import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts_test/EmployeeContext';
import {useContext, useState} from 'react';

const EditForm = (props) =>{

    const [newEmployee, setNewEmployee] = useState({
        name:props.theEmployee.name, date:props.theEmployee.duedate, limit:props.theEmployee.timelimit, points:props.theEmployee.points, desc: props.theEmployee.description
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {name, date, limit, points, desc} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.updateTest(props.theEmployee.testid, name, desc, date, limit, points)
    }

     return (

        <Form onSubmit={handleSubmit}>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Name *"
                    name="name"
                    value={name}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Description *"
                    name="desc"
                    value={desc}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Test Date *"
                    name="date"
                    value={date}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Time Limit *"
                    name="limit"
                    value={limit}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Total Points"
                    name="points"
                    value={points}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Button variant="success" type="submit" block>
                Edit Test
            </Button>
        </Form>

     )
}

export default EditForm;

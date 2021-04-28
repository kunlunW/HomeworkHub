import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts_due/EmployeeContext';
import {useContext, useState} from 'react';

const EditForm = (props) =>{

    const [newEmployee, setNewEmployee] = useState({
        name:props.theEmployee.name, desc:props.theEmployee.description, duedate:props.theEmployee.duedate, points:props.theEmployee.points
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {name, desc, duedate, points} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.updateHomework(props.theEmployee.homeworkid, name, desc, duedate, points);
    }

     return (

        <Form onSubmit={handleSubmit}>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Name"
                    name="name"
                    value={name}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Description"
                    name="desc"
                    value={desc}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Due Date"
                    name="duedate"
                    value={duedate}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Points"
                    name="points"
                    value={points}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Button variant="success" type="submit" block>
                Edit Homework
            </Button>
        </Form>

     )
}

export default EditForm;

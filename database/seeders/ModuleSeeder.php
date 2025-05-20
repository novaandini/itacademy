<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert(
        [
            [
                'id' => 1,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Web Development Foundations',
                'description' => '<ul>
                    <li>What is Web Development (Frontend vs Backend)</li>
                    <li>How the Internet Works (DNS, HTTP/HTTPS, Hosting)</li>
                    <li>Setting Up Dev Environment (VS Code, GitHub, Chrome DevTools)</li>
                </ul>',
                'learning_objectives' => 'To Knwing Web Development Foundation',
                'content' => '',
                'duration_hours' => 4,
                'activities' => 'material & assessment',
                'passing_grade' => 90,
                'module_status' => 'draft',
                'resources' => 'youtube videos & text books',
                'prerequisites' => '',
            ],
            [
                'id' => 2,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'HTML & CSS Basics',
                'description' => '<ul>
                    <li>HTML5 Semantic Elements</li>
                    <li>CSS Fundamentals: Selectors, Box Model, Flexbox, Grid</li>
                    <li>Responsive Design + Media Queries</li>
                </ul>',
                'learning_objectives' => 'To Knpwing Basic HTML & CSSs',
                'content' => 'youtube videos & textbooks',
                'duration_hours' => 6,
                'activities' => 'Mini project: Personal Portfolio Page',
                'passing_grade' => 90,
                'module_status' => 'draft',
                'resources' => null,
                'prerequisites' => '',
            ],
            [
                'id' => 3,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Git & Version Control',
                'description' => '<ul>
                    <li>Git Basics (init, add, commit, push)</li>
                    <li>Working with GitHub</li>
                    <li>Branching, Merge Conflicts</li>
                </ul>',
                'learning_objectives' => 'To Knowing Git & Version Control',
                'content' => 'youtube videos & textbooks',
                'duration_hours' => 2,
                'activities' => 'Hands-on: Team Collaboration Simulation',
                'passing_grade' => 70,
                'module_status' => 'draft',
                'resources' => null,
                'prerequisites' => null,
            ],
            [
                'id' => 4,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'JavaScript (Core Concepts)',
                'description' => '<ul>
                    <li>Syntax, Variables, Data Types</li>
                    <li>Loops, Functions, Arrays, Objects</li>
                    <li>DOM Manipulation</li>
                    <li>Event Handling</li>
                </ul>',
                'learning_objectives' => 'To Knowing Git & Version Control',
                'content' => 'youtube videos & textbooks',
                'duration_hours' => 2,
                'activities' => 'Mini Project: To-Do List App',
                'passing_grade' => 80,
                'module_status' => null,
                'resources' => null,
                'prerequisites' => null,
            ],
            [
                'id' => 5,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Advanced JavaScript + ES6',
                'description' => '<ul>
                    <li>Arrow Functions, Template Literals, Destructuring</li>
                    <li>Promises, Async/Await, Fetch API</li>
                    <li>Local Storage & JSON</li>
                </ul>',
                'learning_objectives' => 'To Knowing Git & Version Control',
                'content' => 'youtube videos & textbooks',
                'duration_hours' => 8,
                'activities' => 'Mini Project: Weather App using API',
                'passing_grade' => null,
                'module_status' => null,
                'resources' => null,
                'prerequisites' => null,
            ],
            [
                'id' => 6,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Web Architecture & Backend Intro',
                'description' => '<ul>
                    <li>What is a Server? What is a Database?</li>
                    <li>Intro to Node.js & Express</li>
                    <li>Building RESTful APIs</li>
                    <li>Connecting to MongoDB (using Mongoose)</li>
                    <li>CRUD Operations</li>
                </ul>',
                'learning_objectives' => 'To Knowing Git & Version Control',
                'content' => 'Project: Notes API',
                'duration_hours' => 5,
                'activities' => null,
                'passing_grade' => null,
                'module_status' => null,
                'resources' => null,
                'prerequisites' => null,
            ],
            [
                'id' => 7,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Frontend with React',
                'description' => '<ul>
                    <li>React Fundamentals (Components, Props, State)</li>
                    <li>JSX, useEffect, useState</li>
                    <li>React Router</li>
                    <li>Component Styling with CSS Modules</li>
                </ul>',
                'learning_objectives' => 'To Knowing Git & Version Control',
                'content' => 'Mini Project: Blog Frontend',
                'duration_hours' => null,
                'activities' => null,
                'passing_grade' => null,
                'module_status' => null,
                'resources' => null,
                'prerequisites' => null,
            ],
            [
                'id' => 8,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Full Stack Integration',
                'description' => '<ul>
                    <li>Connecting Frontend (React) to Backend (Express API)</li>
                    <li>Authentication with JWT</li>
                    <li>Deploying Backend (Render/Vercel/Heroku)</li>
                </ul>',
                'learning_objectives' => 'Project: MERN Stack Blog App',
                'content' => null,
                'duration_hours' => null,
                'activities' => null,
                'passing_grade' => null,
                'module_status' => null,
                'resources' => null,
                'prerequisites' => null,
            ],
            [
                'id' => 9,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Deployment & DevOps Basics',
                'description' => '<ul>
                    <li>Hosting Frontend with Vercel or Netlify</li>
                    <li>Deploying Full Stack App</li>
                    <li>Environment Variables</li>
                    <li>Basic CI/CD with GitHub Actions</li>
                </ul>',
                'learning_objectives' => null,
                'content' => null,
                'duration_hours' => null,
                'activities' => null,
                'passing_grade' => null,
                'module_status' => null,
                'resources' => null,
                'prerequisites' => null,
            ],
            [
                'id' => 10,
                'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
                'module_id' => Str::random(8),
                'title' => 'Career Prep + Final Project',
                'description' => null,
                'learning_objectives' => null,
                'content' => null,
                'duration_hours' => null,
                'activities' => null,
                'passing_grade' => null,
                'module_status' => null,
                'resources' => null,
                'prerequisites' => null,
            ],
        ]
        );
    }
}

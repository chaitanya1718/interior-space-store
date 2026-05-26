pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'chaitanyag18/furniture-store:v1'
    }

    stages {

        stage('Clone Repository') {
            steps {
                git 'https://github.com/chaitanya1718/interior-space-store'
            }
        }

        stage('Build Docker Image') {
            steps {
                bat 'docker build -t %DOCKER_IMAGE% .'
            }
        }

        stage('Push Docker Image') {
            steps {
                bat 'docker push %DOCKER_IMAGE%'
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                bat 'kubectl apply -f deployment.yaml'
                bat 'kubectl apply -f service.yaml'
            }
        }
    }
}



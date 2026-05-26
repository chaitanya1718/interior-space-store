pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'chaitanyag18/furniture-store:v1'
    }

    stages {

        stage('Clone Repository') {
            steps {
                git branch: 'main',
                url: 'https://github.com/chaitanya1718/interior-space-store.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $DOCKER_IMAGE .'
            }
        }

        stage('Push Docker Image') {
    steps {
        withCredentials([usernamePassword(
            credentialsId: 'dockerhub',
            usernameVariable: 'DOCKER_USER',
            passwordVariable: 'DOCKER_PASS'
        )]) {

            sh 'echo $DOCKER_PASS | docker login -u $DOCKER_USER --password-stdin'
            sh 'docker push $DOCKER_IMAGE'
        }
    }
}

        // stage('Deploy Kubernetes') {
        //     steps {
        //         sh 'kubectl apply -f deployment.yaml'
        //         sh 'kubectl apply -f service.yaml'
        //     }
        // }
    }
}
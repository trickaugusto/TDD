# Anotações

## Patterns for writing good tests:
Arrange, act, assert - https://automationpanda.com/2020/07/07/arrange-act-assert-a-pattern-for-writing-good-tests/
Give, when, then - https://medium.com/@matheus.saraujo/testes-give-when-then-3bf3fef55f5e

## Muitos testes na aplicação?
Preciso escrever um teste pra cada detalhe da aplicação? Não. 
Pra evitar isso, podemos usar algumas técnicas como: 

### Técnica de classes de equivalência
Basta apenas pegar os cenários que podem ser testados em apenas um teste, e juntá-los. Por exemplo:
![](image.png)

### Análise de valor de limite/fronteira
Nesse cenário, testamos sempre o valor mais próximmo do valor limite:
![](image-1.png)

Ver mais em: http://testwarequality.blogspot.com/p/tenicas-de-teste.html
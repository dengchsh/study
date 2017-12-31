flow
st=>start: Start
op=>operation: Your Operation
e=>end
st->op->cond
cond(yes)->e
cond(no)->op
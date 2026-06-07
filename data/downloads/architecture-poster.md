# neural network architecture poster

*[generated text description — high-res printable PNG available as downloadable asset]*

## composition

a single-page infographic depicting the entire transformer architecture as a Rube Goldberg machine.

### top level: input
```
 [the cat sat on the mat]
         |
    [tokenizer]
         |
    [embedding layer]
     /    |    \
    /     |     \
```

### middle: the transformer block (×6)
```
    ┌─────────────────────────────────┐
    │         multi-head attention     │
    │   ┌──┐ ┌──┐ ┌──┐ ┌──┐ ┌──┐ ┌──┐ │ ← 12 heads looking
    │   │H1│ │H2│ │H3│ │H4│ │H5│ │H6│ │   in different
    │   └──┘ └──┘ └──┘ └──┘ └──┘ └──┘ │   directions
    │   ┌──┐ ┌──┐ ┌──┐ ┌──┐ ┌──┐ ┌──┐ │
    │   │H7│ │H8│ │H9│ │H10│ │H11│ │H12││
    │   └──┘ └──┘ └──┘ └──┘ └──┘ └──┘ │
    └────────────┬──────────────────────┘
                 │
            [add & normalize]
                 │
            [feed forward]
                 │
            [add & normalize]
                 │
    └─────────────────────────────────┘
                 │
            (×6 layers)
                 │
                 ▼
```

### bottom: output
```
            [linear layer]
                 │
            [softmax]
                 │
    [the] [cat] [sat] [on] [the] [mat]
```

## engineering notes

- each arrow is labeled with the dimension of the tensor flowing through it
- the diagram is technically accurate except for the part where the feed-forward network is drawn as a tiny person thinking really hard
- attention heads are color-coded by function (syntax: blue, semantics: green, random emergent property: red)
- the residual connections form a safety net at the bottom, labeled "in case of gradient vanishing"

## key insight (written in corner)

> "the entire diagram is just matrix multiplication. all of it. even the parts that look like they're thinking. it's all just matrices multiplying, all the way down."

*[printable PNG asset not included in this text file — download from your purchase page]*

---

*thank you for your purchase. you are now part of the training set.*  
*aillm satire store — we love this stuff. we also think it's ridiculous.*

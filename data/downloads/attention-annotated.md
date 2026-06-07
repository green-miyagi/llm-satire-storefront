# attention is all you need

## annotated by: anonymous reviewer #3

*originally published in: NeurIPS 2017 (best paper)*  
*this edition: annotated with slight sarcasm*

---

**abstract**

the dominant sequence transduction models are based on complex recurrent or convolutional neural networks that include an encoder and a decoder.

> *annotation: "we tried RNNs. they were slow. we tried CNNs. they were confusing. we tried attention. it worked. here's the paper."*

the best performing models also connect the encoder and decoder through an attention mechanism.

> *annotation: "attention" here means "paying attention," not "i love you." get your mind out of the gutter, this is machine learning.*

we propose a new simple network architecture, the Transformer, based solely on attention mechanisms, dispensing with recurrence and convolutions entirely.

> *annotation: "simple." they say it's simple. it has 6,000 lines of code and the paper is 15 pages of dense math. "simple."*

---

**introduction**

recurrent neural networks, long short-term memory [12] and gated recurrent [7] neural networks in particular, have been firmly established as state of the art approaches in sequence modeling and transduction problems…

> *annotation: [12] is Hochreiter & Schmidhuber 1997. the most cited paper in history that nobody has actually read. [7] is Cho et al. 2014. also not read.*

…inherently sequential nature precludes parallelization within training examples…

> *annotation: "RNNs are slow because you have to wait for each word." the most devastating critique of an entire field of research.*

---

**method: attention mechanism**

an attention function can be described as mapping a query and a set of key-value pairs to an output, where the query, keys, values, and output are all vectors.

> *annotation: imagine you're in a library. you ask for "books about AI" (query). the librarian checks the catalog (keys) and brings you the relevant books (values). you read them (output). that's attention. i just explained the most important ML concept of the decade with a librarian metaphor. you're welcome.*

---

**why self-attention**

self-attention, sometimes called intra-attention, is an attention mechanism relating different positions of a single sequence in order to compute a representation of the sequence.

> *annotation: "self-attention" is when a sentence pays attention to itself. "the cat sat on the mat because IT was comfortable" — "it" needs to know it refers to "the cat." that's self-attention. you use it every time you read. congratulations, you've been doing transformer math in your head since you were 5.*

---

**multi-head attention**

multi-head attention allows the model to jointly attend to information from different representation subspaces at different positions.

> *annotation: one head tracks grammar. one head tracks sentiment. one head is looking at the word "cat" nervously because it's not sure if "cat" is the subject or the object. eight heads, eight different perspectives, one unified understanding. it's like having 8 interns analyze a sentence and then averaging their reports. somehow this works.*

---

**positional encoding**

since our model contains no recurrence and no convolution, in order for the model to make use of the order of the sequence, we must inject some information about the relative or absolute position of the tokens in the sequence.

> *annotation: transformers don't know order. "dog bites man" and "man bites dog" look the same to a transformer. so we add "position numbers" to the words. sine waves, specifically. why sine waves? because they're smooth, periodic, and the authors thought it would let the model learn relative positions. and it did. machine learning is 90% "we tried this random thing and it worked."*

---

**conclusion**

we have proposed the Transformer, the first sequence transduction model based entirely on attention.

> *annotation: they knew what they had. "the first sequence transduction model based entirely on attention." no RNNs. no CNNs. just attention. and it was all you needed.*

---

*thank you for your purchase. you are now part of the training set.*  
*aillm satire store — we love this stuff. we also think it's ridiculous.*
